#!/usr/bin/env node

import { McpServer } from "@modelcontextprotocol/sdk/server/mcp.js";
import { StdioServerTransport } from "@modelcontextprotocol/sdk/server/stdio.js";
import { z } from "zod";

// --- Configuration ---

const WP_URL = process.env.WP_URL || "https://www.menil53.fr";
const WP_USER = process.env.WP_USER;
const WP_APP_PASSWORD = process.env.WP_APP_PASSWORD;

if (!WP_USER || !WP_APP_PASSWORD) {
  console.error(
    "ERREUR: Les variables WP_USER et WP_APP_PASSWORD sont requises.\n" +
      "Créez un mot de passe d'application dans WordPress :\n" +
      "  Tableau de bord → Utilisateurs → Votre profil → Mots de passe d'application"
  );
  process.exit(1);
}

const AUTH_HEADER =
  "Basic " + Buffer.from(`${WP_USER}:${WP_APP_PASSWORD}`).toString("base64");

// --- WordPress REST API helper ---

async function wpApi(endpoint, options = {}) {
  const url = `${WP_URL}/wp-json${endpoint}`;
  const res = await fetch(url, {
    ...options,
    headers: {
      Authorization: AUTH_HEADER,
      "Content-Type": "application/json",
      ...options.headers,
    },
  });
  if (!res.ok) {
    const body = await res.text();
    throw new Error(`WordPress API ${res.status}: ${body}`);
  }
  return res.json();
}

// --- Helpers ---

function stripHtml(html) {
  return html
    .replace(/<[^>]*>/g, "")
    .replace(/&nbsp;/g, " ")
    .replace(/&amp;/g, "&")
    .replace(/&lt;/g, "<")
    .replace(/&gt;/g, ">")
    .replace(/&#8217;/g, "'")
    .replace(/&#8216;/g, "'")
    .replace(/&#8220;/g, '"')
    .replace(/&#8221;/g, '"')
    .replace(/\n{3,}/g, "\n\n")
    .trim();
}

function formatPost(post) {
  return [
    `ID: ${post.id}`,
    `Titre: ${stripHtml(post.title.rendered)}`,
    `Statut: ${post.status}`,
    `Date: ${new Date(post.date).toLocaleString("fr-FR")}`,
    `Modifié: ${new Date(post.modified).toLocaleString("fr-FR")}`,
    `Lien: ${post.link}`,
    `Extrait: ${stripHtml(post.excerpt?.rendered || "")}`,
  ].join("\n");
}

function formatPage(page) {
  return [
    `ID: ${page.id}`,
    `Titre: ${stripHtml(page.title.rendered)}`,
    `Statut: ${page.status}`,
    `Date: ${new Date(page.date).toLocaleString("fr-FR")}`,
    `Modifié: ${new Date(page.modified).toLocaleString("fr-FR")}`,
    `Lien: ${page.link}`,
  ].join("\n");
}

// --- MCP Server ---

const server = new McpServer({
  name: "menil53-wordpress",
  version: "1.0.0",
});

// =====================
// OUTILS DE CONSULTATION
// =====================

// Tool: Infos générales du site
server.tool(
  "infos_site",
  "Affiche les informations générales du site WordPress menil53.fr (nom, description, URL, version)",
  {},
  async () => {
    try {
      const info = await wpApi("/");
      return {
        content: [
          {
            type: "text",
            text: [
              `Nom: ${info.name}`,
              `Description: ${info.description}`,
              `URL: ${info.url}`,
              `Accueil: ${info.home}`,
              `Fuseau: ${info.timezone_string || info.gmt_offset}`,
              `Namespaces: ${info.namespaces?.join(", ") || "N/A"}`,
            ].join("\n"),
          },
        ],
      };
    } catch (e) {
      return {
        content: [{ type: "text", text: `Erreur: ${e.message}` }],
        isError: true,
      };
    }
  }
);

// Tool: Lister les articles
server.tool(
  "lister_articles",
  "Liste les articles du site (actualités, événements). Filtrable par statut et nombre.",
  {
    nombre: z
      .number()
      .optional()
      .default(10)
      .describe("Nombre d'articles à récupérer (défaut: 10, max: 100)"),
    statut: z
      .enum(["publish", "draft", "pending", "private", "any"])
      .optional()
      .default("publish")
      .describe("Statut des articles (défaut: publish)"),
    recherche: z
      .string()
      .optional()
      .describe("Rechercher dans les articles"),
  },
  async ({ nombre, statut, recherche }) => {
    try {
      let endpoint = `/wp/v2/posts?per_page=${Math.min(nombre, 100)}&_embed`;
      if (statut && statut !== "any") endpoint += `&status=${statut}`;
      if (recherche) endpoint += `&search=${encodeURIComponent(recherche)}`;

      const posts = await wpApi(endpoint);
      if (posts.length === 0) {
        return {
          content: [{ type: "text", text: "Aucun article trouvé." }],
        };
      }
      const list = posts.map(
        (p, i) => `--- Article ${i + 1} ---\n${formatPost(p)}`
      );
      return {
        content: [
          {
            type: "text",
            text: `${posts.length} article(s) trouvé(s):\n\n${list.join("\n\n")}`,
          },
        ],
      };
    } catch (e) {
      return {
        content: [{ type: "text", text: `Erreur: ${e.message}` }],
        isError: true,
      };
    }
  }
);

// Tool: Lire un article complet
server.tool(
  "lire_article",
  "Lit le contenu complet d'un article par son ID",
  {
    id: z.number().describe("ID de l'article à lire"),
  },
  async ({ id }) => {
    try {
      const post = await wpApi(`/wp/v2/posts/${id}`);
      return {
        content: [
          {
            type: "text",
            text: [
              formatPost(post),
              "",
              "--- Contenu ---",
              stripHtml(post.content.rendered),
            ].join("\n"),
          },
        ],
      };
    } catch (e) {
      return {
        content: [{ type: "text", text: `Erreur: ${e.message}` }],
        isError: true,
      };
    }
  }
);

// Tool: Lister les pages
server.tool(
  "lister_pages",
  "Liste toutes les pages du site (Accueil, Agenda, Conseil Municipal, etc.)",
  {
    nombre: z
      .number()
      .optional()
      .default(20)
      .describe("Nombre de pages à récupérer (défaut: 20)"),
    statut: z
      .enum(["publish", "draft", "pending", "private", "any"])
      .optional()
      .default("publish")
      .describe("Statut des pages"),
  },
  async ({ nombre, statut }) => {
    try {
      let endpoint = `/wp/v2/pages?per_page=${Math.min(nombre, 100)}`;
      if (statut && statut !== "any") endpoint += `&status=${statut}`;

      const pages = await wpApi(endpoint);
      if (pages.length === 0) {
        return {
          content: [{ type: "text", text: "Aucune page trouvée." }],
        };
      }
      const list = pages.map(
        (p, i) => `--- Page ${i + 1} ---\n${formatPage(p)}`
      );
      return {
        content: [
          {
            type: "text",
            text: `${pages.length} page(s) trouvée(s):\n\n${list.join("\n\n")}`,
          },
        ],
      };
    } catch (e) {
      return {
        content: [{ type: "text", text: `Erreur: ${e.message}` }],
        isError: true,
      };
    }
  }
);

// Tool: Lire une page complète
server.tool(
  "lire_page",
  "Lit le contenu complet d'une page par son ID",
  {
    id: z.number().describe("ID de la page à lire"),
  },
  async ({ id }) => {
    try {
      const page = await wpApi(`/wp/v2/pages/${id}`);
      return {
        content: [
          {
            type: "text",
            text: [
              formatPage(page),
              "",
              "--- Contenu ---",
              stripHtml(page.content.rendered),
            ].join("\n"),
          },
        ],
      };
    } catch (e) {
      return {
        content: [{ type: "text", text: `Erreur: ${e.message}` }],
        isError: true,
      };
    }
  }
);

// Tool: Lister les catégories
server.tool(
  "lister_categories",
  "Liste les catégories d'articles du site",
  {},
  async () => {
    try {
      const cats = await wpApi("/wp/v2/categories?per_page=100");
      const list = cats.map(
        (c) =>
          `- ${c.name} (ID: ${c.id}, ${c.count} article(s))${c.description ? ` — ${c.description}` : ""}`
      );
      return {
        content: [
          {
            type: "text",
            text: `Catégories:\n\n${list.join("\n")}`,
          },
        ],
      };
    } catch (e) {
      return {
        content: [{ type: "text", text: `Erreur: ${e.message}` }],
        isError: true,
      };
    }
  }
);

// Tool: Lister les médias
server.tool(
  "lister_medias",
  "Liste les fichiers médias (images, PDFs) du site",
  {
    nombre: z
      .number()
      .optional()
      .default(10)
      .describe("Nombre de médias à récupérer"),
    type_media: z
      .enum(["image", "application", "video", "audio", "tous"])
      .optional()
      .default("tous")
      .describe("Type de média à filtrer"),
  },
  async ({ nombre, type_media }) => {
    try {
      let endpoint = `/wp/v2/media?per_page=${Math.min(nombre, 100)}`;
      if (type_media && type_media !== "tous")
        endpoint += `&media_type=${type_media}`;

      const medias = await wpApi(endpoint);
      const list = medias.map((m) => {
        const size = m.media_details?.filesize
          ? `${Math.round(m.media_details.filesize / 1024)} Ko`
          : "N/A";
        return `- ${stripHtml(m.title.rendered)} (ID: ${m.id}, ${m.mime_type}, ${size})\n  ${m.source_url}`;
      });
      return {
        content: [
          {
            type: "text",
            text: `${medias.length} média(s):\n\n${list.join("\n")}`,
          },
        ],
      };
    } catch (e) {
      return {
        content: [{ type: "text", text: `Erreur: ${e.message}` }],
        isError: true,
      };
    }
  }
);

// =====================
// OUTILS DE MODIFICATION
// =====================

// Tool: Créer un article
server.tool(
  "creer_article",
  "Crée un nouvel article (actualité, événement) sur le site",
  {
    titre: z.string().describe("Titre de l'article"),
    contenu: z
      .string()
      .describe(
        "Contenu de l'article en HTML. Utilisez <p>, <h2>, <ul><li>, <strong>, <em>, <a href> pour le formatage."
      ),
    statut: z
      .enum(["publish", "draft"])
      .optional()
      .default("draft")
      .describe(
        "Statut: 'draft' pour brouillon (défaut), 'publish' pour publier immédiatement"
      ),
    categories: z
      .array(z.number())
      .optional()
      .describe("IDs des catégories (utilisez lister_categories pour les voir)"),
    extrait: z.string().optional().describe("Extrait/résumé court de l'article"),
  },
  async ({ titre, contenu, statut, categories, extrait }) => {
    try {
      const body = {
        title: titre,
        content: contenu,
        status: statut,
      };
      if (categories) body.categories = categories;
      if (extrait) body.excerpt = extrait;

      const post = await wpApi("/wp/v2/posts", {
        method: "POST",
        body: JSON.stringify(body),
      });
      return {
        content: [
          {
            type: "text",
            text: `Article créé avec succès !\n\n${formatPost(post)}\n\n${statut === "draft" ? "L'article est en brouillon. Utilisez modifier_article pour le publier." : "L'article est publié et visible sur le site."}`,
          },
        ],
      };
    } catch (e) {
      return {
        content: [{ type: "text", text: `Erreur: ${e.message}` }],
        isError: true,
      };
    }
  }
);

// Tool: Modifier un article
server.tool(
  "modifier_article",
  "Modifie un article existant (titre, contenu, statut, catégories)",
  {
    id: z.number().describe("ID de l'article à modifier"),
    titre: z.string().optional().describe("Nouveau titre"),
    contenu: z.string().optional().describe("Nouveau contenu HTML"),
    statut: z
      .enum(["publish", "draft", "pending", "private"])
      .optional()
      .describe("Nouveau statut"),
    categories: z
      .array(z.number())
      .optional()
      .describe("Nouvelles catégories (IDs)"),
    extrait: z.string().optional().describe("Nouvel extrait"),
  },
  async ({ id, titre, contenu, statut, categories, extrait }) => {
    try {
      const body = {};
      if (titre) body.title = titre;
      if (contenu) body.content = contenu;
      if (statut) body.status = statut;
      if (categories) body.categories = categories;
      if (extrait) body.excerpt = extrait;

      if (Object.keys(body).length === 0) {
        return {
          content: [
            {
              type: "text",
              text: "Aucune modification spécifiée. Indiquez au moins un champ à modifier.",
            },
          ],
          isError: true,
        };
      }

      const post = await wpApi(`/wp/v2/posts/${id}`, {
        method: "POST",
        body: JSON.stringify(body),
      });
      return {
        content: [
          {
            type: "text",
            text: `Article modifié avec succès !\n\n${formatPost(post)}`,
          },
        ],
      };
    } catch (e) {
      return {
        content: [{ type: "text", text: `Erreur: ${e.message}` }],
        isError: true,
      };
    }
  }
);

// Tool: Supprimer un article
server.tool(
  "supprimer_article",
  "Supprime un article (le met dans la corbeille par défaut)",
  {
    id: z.number().describe("ID de l'article à supprimer"),
    definitif: z
      .boolean()
      .optional()
      .default(false)
      .describe(
        "true pour supprimer définitivement, false pour mettre à la corbeille (défaut)"
      ),
  },
  async ({ id, definitif }) => {
    try {
      const post = await wpApi(
        `/wp/v2/posts/${id}?force=${definitif}`,
        { method: "DELETE" }
      );
      return {
        content: [
          {
            type: "text",
            text: definitif
              ? `Article ${id} supprimé définitivement.`
              : `Article "${stripHtml(post.title.rendered)}" mis à la corbeille. Il peut être restauré depuis le tableau de bord WordPress.`,
          },
        ],
      };
    } catch (e) {
      return {
        content: [{ type: "text", text: `Erreur: ${e.message}` }],
        isError: true,
      };
    }
  }
);

// Tool: Modifier une page
server.tool(
  "modifier_page",
  "Modifie une page existante du site (titre, contenu, statut)",
  {
    id: z.number().describe("ID de la page à modifier"),
    titre: z.string().optional().describe("Nouveau titre"),
    contenu: z.string().optional().describe("Nouveau contenu HTML"),
    statut: z
      .enum(["publish", "draft", "pending", "private"])
      .optional()
      .describe("Nouveau statut"),
  },
  async ({ id, titre, contenu, statut }) => {
    try {
      const body = {};
      if (titre) body.title = titre;
      if (contenu) body.content = contenu;
      if (statut) body.status = statut;

      if (Object.keys(body).length === 0) {
        return {
          content: [
            {
              type: "text",
              text: "Aucune modification spécifiée.",
            },
          ],
          isError: true,
        };
      }

      const page = await wpApi(`/wp/v2/pages/${id}`, {
        method: "POST",
        body: JSON.stringify(body),
      });
      return {
        content: [
          {
            type: "text",
            text: `Page modifiée avec succès !\n\n${formatPage(page)}`,
          },
        ],
      };
    } catch (e) {
      return {
        content: [{ type: "text", text: `Erreur: ${e.message}` }],
        isError: true,
      };
    }
  }
);

// =====================
// OUTILS DE MAINTENANCE
// =====================

// Tool: Lister les utilisateurs
server.tool(
  "lister_utilisateurs",
  "Liste les utilisateurs du site WordPress",
  {},
  async () => {
    try {
      const users = await wpApi("/wp/v2/users?per_page=100");
      const list = users.map(
        (u) =>
          `- ${u.name} (ID: ${u.id}, rôle: ${u.roles?.join(", ") || "N/A"}, slug: ${u.slug})`
      );
      return {
        content: [
          {
            type: "text",
            text: `Utilisateurs:\n\n${list.join("\n")}`,
          },
        ],
      };
    } catch (e) {
      return {
        content: [{ type: "text", text: `Erreur: ${e.message}` }],
        isError: true,
      };
    }
  }
);

// Tool: Lister les commentaires
server.tool(
  "lister_commentaires",
  "Liste les commentaires récents du site",
  {
    nombre: z
      .number()
      .optional()
      .default(10)
      .describe("Nombre de commentaires"),
    statut: z
      .enum(["approved", "hold", "spam", "trash"])
      .optional()
      .default("approved")
      .describe("Statut des commentaires"),
  },
  async ({ nombre, statut }) => {
    try {
      const comments = await wpApi(
        `/wp/v2/comments?per_page=${nombre}&status=${statut}`
      );
      if (comments.length === 0) {
        return {
          content: [{ type: "text", text: "Aucun commentaire trouvé." }],
        };
      }
      const list = comments.map(
        (c) =>
          `- [${new Date(c.date).toLocaleString("fr-FR")}] ${c.author_name}: ${stripHtml(c.content.rendered).slice(0, 100)}... (ID: ${c.id}, article: ${c.post})`
      );
      return {
        content: [
          {
            type: "text",
            text: `${comments.length} commentaire(s):\n\n${list.join("\n")}`,
          },
        ],
      };
    } catch (e) {
      return {
        content: [{ type: "text", text: `Erreur: ${e.message}` }],
        isError: true,
      };
    }
  }
);

// Tool: Modérer un commentaire
server.tool(
  "moderer_commentaire",
  "Approuve, met en attente ou supprime un commentaire",
  {
    id: z.number().describe("ID du commentaire"),
    action: z
      .enum(["approuver", "attente", "spam", "supprimer"])
      .describe("Action de modération"),
  },
  async ({ id, action }) => {
    try {
      if (action === "supprimer") {
        await wpApi(`/wp/v2/comments/${id}?force=true`, {
          method: "DELETE",
        });
        return {
          content: [
            { type: "text", text: `Commentaire ${id} supprimé.` },
          ],
        };
      }

      const statusMap = {
        approuver: "approved",
        attente: "hold",
        spam: "spam",
      };
      const comment = await wpApi(`/wp/v2/comments/${id}`, {
        method: "POST",
        body: JSON.stringify({ status: statusMap[action] }),
      });
      return {
        content: [
          {
            type: "text",
            text: `Commentaire ${id} — statut changé en "${action}".`,
          },
        ],
      };
    } catch (e) {
      return {
        content: [{ type: "text", text: `Erreur: ${e.message}` }],
        isError: true,
      };
    }
  }
);

// Tool: Vérifier les mises à jour WordPress
server.tool(
  "verifier_mises_a_jour",
  "Vérifie les mises à jour disponibles pour WordPress, les thèmes et les plugins (nécessite les droits administrateur)",
  {},
  async () => {
    try {
      // Try to get plugins list (requires admin)
      const plugins = await wpApi("/wp/v2/plugins").catch(() => null);
      const themes = await wpApi("/wp/v2/themes").catch(() => null);

      const lines = [];

      if (plugins) {
        lines.push("--- Plugins ---");
        for (const p of plugins) {
          const status = p.status === "active" ? "actif" : "inactif";
          lines.push(
            `- ${p.name} v${p.version} (${status})${p.update?.version ? ` → mise à jour ${p.update.version} disponible` : ""}`
          );
        }
      } else {
        lines.push(
          "Plugins: accès refusé (droits administrateur requis, ou l'endpoint n'est pas disponible)"
        );
      }

      if (themes) {
        lines.push("\n--- Thèmes ---");
        for (const t of themes) {
          const status = t.status === "active" ? "actif" : "inactif";
          lines.push(
            `- ${t.name?.rendered || t.stylesheet} v${t.version} (${status})`
          );
        }
      } else {
        lines.push(
          "Thèmes: accès refusé (droits administrateur requis, ou l'endpoint n'est pas disponible)"
        );
      }

      return {
        content: [{ type: "text", text: lines.join("\n") }],
      };
    } catch (e) {
      return {
        content: [{ type: "text", text: `Erreur: ${e.message}` }],
        isError: true,
      };
    }
  }
);

// --- Start server ---

const transport = new StdioServerTransport();
await server.connect(transport);
