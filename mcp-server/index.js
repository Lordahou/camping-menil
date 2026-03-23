#!/usr/bin/env node

import { McpServer } from "@modelcontextprotocol/sdk/server/mcp.js";
import { StdioServerTransport } from "@modelcontextprotocol/sdk/server/stdio.js";
import { z } from "zod";

const GITHUB_OWNER = process.env.GITHUB_OWNER || "Lordahou";
const GITHUB_REPO = process.env.GITHUB_REPO || "camping-menil";
const GITHUB_BRANCH = process.env.GITHUB_BRANCH || "main";
const GITHUB_TOKEN = process.env.GITHUB_TOKEN;
const CONTENT_PATH = "src/data/content.json";

if (!GITHUB_TOKEN) {
  console.error(
    "ERREUR: La variable GITHUB_TOKEN est requise. Créez un token sur https://github.com/settings/tokens"
  );
  process.exit(1);
}

// --- GitHub API helpers ---

async function githubApi(endpoint, options = {}) {
  const url = `https://api.github.com/repos/${GITHUB_OWNER}/${GITHUB_REPO}${endpoint}`;
  const res = await fetch(url, {
    ...options,
    headers: {
      Authorization: `Bearer ${GITHUB_TOKEN}`,
      Accept: "application/vnd.github.v3+json",
      "Content-Type": "application/json",
      ...options.headers,
    },
  });
  if (!res.ok) {
    const body = await res.text();
    throw new Error(`GitHub API ${res.status}: ${body}`);
  }
  return res.json();
}

async function getContentFile() {
  const data = await githubApi(
    `/contents/${CONTENT_PATH}?ref=${GITHUB_BRANCH}`
  );
  const content = JSON.parse(
    Buffer.from(data.content, "base64").toString("utf-8")
  );
  return { content, sha: data.sha };
}

async function updateContentFile(content, sha, message) {
  const encoded = Buffer.from(JSON.stringify(content, null, 2) + "\n").toString(
    "base64"
  );
  return githubApi(`/contents/${CONTENT_PATH}`, {
    method: "PUT",
    body: JSON.stringify({
      message,
      content: encoded,
      sha,
      branch: GITHUB_BRANCH,
    }),
  });
}

// --- Sections disponibles ---

const SECTIONS = [
  "site",
  "contact",
  "openingDates",
  "hero",
  "highlights",
  "accommodations",
  "services",
  "activities",
  "surroundings",
  "bac",
  "tarifs",
  "testimonials",
  "faq",
  "navigation",
  "footerLinks",
];

// --- MCP Server ---

const server = new McpServer({
  name: "camping-menil",
  version: "1.0.0",
});

// Resource: lire tout le contenu
server.resource("contenu-complet", "camping://contenu", async (uri) => ({
  contents: [
    {
      uri: uri.href,
      mimeType: "application/json",
      text: JSON.stringify((await getContentFile()).content, null, 2),
    },
  ],
}));

// Resource: lire une section spécifique
for (const section of SECTIONS) {
  server.resource(
    `section-${section}`,
    `camping://contenu/${section}`,
    async (uri) => {
      const { content } = await getContentFile();
      return {
        contents: [
          {
            uri: uri.href,
            mimeType: "application/json",
            text: JSON.stringify(content[section], null, 2),
          },
        ],
      };
    }
  );
}

// Tool: Lister les sections disponibles
server.tool(
  "lister_sections",
  "Liste toutes les sections modifiables du site (tarifs, hébergements, activités, FAQ, etc.)",
  {},
  async () => {
    const { content } = await getContentFile();
    const summary = SECTIONS.map((s) => {
      const val = content[s];
      const type = Array.isArray(val)
        ? `tableau (${val.length} éléments)`
        : typeof val === "object"
          ? `objet (${Object.keys(val).length} clés)`
          : typeof val;
      return `- ${s}: ${type}`;
    });
    return {
      content: [
        {
          type: "text",
          text: `Sections du site Camping du Bac de Ménil:\n\n${summary.join("\n")}`,
        },
      ],
    };
  }
);

// Tool: Lire une section
server.tool(
  "lire_section",
  "Lit le contenu d'une section spécifique du site (ex: tarifs, accommodations, faq, contact...)",
  { section: z.enum(SECTIONS).describe("Nom de la section à lire") },
  async ({ section }) => {
    const { content } = await getContentFile();
    if (!(section in content)) {
      return {
        content: [
          {
            type: "text",
            text: `Section "${section}" introuvable. Sections disponibles: ${SECTIONS.join(", ")}`,
          },
        ],
        isError: true,
      };
    }
    return {
      content: [
        {
          type: "text",
          text: JSON.stringify(content[section], null, 2),
        },
      ],
    };
  }
);

// Tool: Modifier une section complète
server.tool(
  "modifier_section",
  "Remplace entièrement le contenu d'une section du site. Utilisez lire_section d'abord pour voir la structure actuelle.",
  {
    section: z.enum(SECTIONS).describe("Nom de la section à modifier"),
    nouveau_contenu: z
      .string()
      .describe("Nouveau contenu de la section au format JSON"),
    message_commit: z
      .string()
      .describe("Message de commit décrivant la modification"),
  },
  async ({ section, nouveau_contenu, message_commit }) => {
    try {
      const parsed = JSON.parse(nouveau_contenu);
      const { content, sha } = await getContentFile();
      content[section] = parsed;
      const result = await updateContentFile(
        content,
        sha,
        `🏕️ ${message_commit}`
      );
      return {
        content: [
          {
            type: "text",
            text: `Section "${section}" mise à jour avec succès.\nCommit: ${result.commit.html_url}\n\nLe site sera automatiquement redéployé via GitHub Actions.`,
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

// Tool: Modifier un champ spécifique dans une section
server.tool(
  "modifier_champ",
  "Modifie un champ spécifique dans une section (ex: changer le téléphone dans contact, ou le prix d'un tarif)",
  {
    section: z.enum(SECTIONS).describe("Nom de la section"),
    chemin: z
      .string()
      .describe(
        'Chemin vers le champ à modifier, séparé par des points (ex: "phone" dans contact, ou "emplacements.items.0.price" dans tarifs)'
      ),
    nouvelle_valeur: z
      .string()
      .describe("Nouvelle valeur (chaîne JSON pour objets/tableaux, texte brut pour valeurs simples)"),
    message_commit: z
      .string()
      .describe("Message de commit décrivant la modification"),
  },
  async ({ section, chemin, nouvelle_valeur, message_commit }) => {
    try {
      const { content, sha } = await getContentFile();
      if (!(section in content)) {
        return {
          content: [
            { type: "text", text: `Section "${section}" introuvable.` },
          ],
          isError: true,
        };
      }

      // Parse the value - try JSON first, fallback to string
      let value;
      try {
        value = JSON.parse(nouvelle_valeur);
      } catch {
        value = nouvelle_valeur;
      }

      // Navigate to the field
      const parts = chemin.split(".");
      let target = content[section];
      for (let i = 0; i < parts.length - 1; i++) {
        const key = isNaN(parts[i]) ? parts[i] : parseInt(parts[i]);
        if (target[key] === undefined) {
          return {
            content: [
              {
                type: "text",
                text: `Chemin invalide: "${chemin}" - "${parts[i]}" n'existe pas.`,
              },
            ],
            isError: true,
          };
        }
        target = target[key];
      }

      const lastKey = isNaN(parts[parts.length - 1])
        ? parts[parts.length - 1]
        : parseInt(parts[parts.length - 1]);

      const ancienne = target[lastKey];
      target[lastKey] = value;

      const result = await updateContentFile(
        content,
        sha,
        `🏕️ ${message_commit}`
      );
      return {
        content: [
          {
            type: "text",
            text: `Champ "${chemin}" dans "${section}" modifié.\nAncienne valeur: ${JSON.stringify(ancienne)}\nNouvelle valeur: ${JSON.stringify(value)}\nCommit: ${result.commit.html_url}`,
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

// Tool: Ajouter un élément à une section tableau
server.tool(
  "ajouter_element",
  "Ajoute un élément à une section qui est un tableau (ex: ajouter un témoignage, une activité, une question FAQ)",
  {
    section: z
      .enum(
        SECTIONS.filter((s) =>
          [
            "highlights",
            "accommodations",
            "services",
            "activities",
            "surroundings",
            "testimonials",
            "faq",
            "navigation",
            "footerLinks",
          ].includes(s)
        )
      )
      .describe("Section tableau où ajouter l'élément"),
    element: z
      .string()
      .describe("Élément à ajouter au format JSON"),
    message_commit: z
      .string()
      .describe("Message de commit"),
  },
  async ({ section, element, message_commit }) => {
    try {
      const parsed = JSON.parse(element);
      const { content, sha } = await getContentFile();

      if (!Array.isArray(content[section])) {
        return {
          content: [
            {
              type: "text",
              text: `"${section}" n'est pas un tableau.`,
            },
          ],
          isError: true,
        };
      }

      content[section].push(parsed);
      const result = await updateContentFile(
        content,
        sha,
        `🏕️ ${message_commit}`
      );
      return {
        content: [
          {
            type: "text",
            text: `Élément ajouté à "${section}" (${content[section].length} éléments au total).\nCommit: ${result.commit.html_url}`,
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

// Tool: Supprimer un élément d'une section tableau
server.tool(
  "supprimer_element",
  "Supprime un élément d'une section tableau par son index (commence à 0)",
  {
    section: z.enum(SECTIONS).describe("Section tableau"),
    index: z.number().describe("Index de l'élément à supprimer (commence à 0)"),
    message_commit: z.string().describe("Message de commit"),
  },
  async ({ section, index, message_commit }) => {
    try {
      const { content, sha } = await getContentFile();

      if (!Array.isArray(content[section])) {
        return {
          content: [
            { type: "text", text: `"${section}" n'est pas un tableau.` },
          ],
          isError: true,
        };
      }

      if (index < 0 || index >= content[section].length) {
        return {
          content: [
            {
              type: "text",
              text: `Index ${index} hors limites (0-${content[section].length - 1}).`,
            },
          ],
          isError: true,
        };
      }

      const supprime = content[section].splice(index, 1)[0];
      const result = await updateContentFile(
        content,
        sha,
        `🏕️ ${message_commit}`
      );
      return {
        content: [
          {
            type: "text",
            text: `Élément supprimé de "${section}":\n${JSON.stringify(supprime, null, 2)}\nCommit: ${result.commit.html_url}`,
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

// Tool: Voir le statut du déploiement
server.tool(
  "statut_deploiement",
  "Vérifie le statut du dernier déploiement GitHub Actions du site",
  {},
  async () => {
    try {
      const runs = await githubApi(
        `/actions/runs?branch=${GITHUB_BRANCH}&per_page=3`
      );
      if (!runs.workflow_runs || runs.workflow_runs.length === 0) {
        return {
          content: [
            { type: "text", text: "Aucun déploiement trouvé." },
          ],
        };
      }
      const summary = runs.workflow_runs.map((r) => {
        const status =
          r.conclusion === "success"
            ? "✅"
            : r.conclusion === "failure"
              ? "❌"
              : "⏳";
        return `${status} ${r.name} — ${r.conclusion || r.status} — ${new Date(r.created_at).toLocaleString("fr-FR")}`;
      });
      return {
        content: [
          {
            type: "text",
            text: `Derniers déploiements:\n\n${summary.join("\n")}`,
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

// Tool: Voir les derniers commits
server.tool(
  "derniers_commits",
  "Affiche les derniers commits sur le site pour voir l'historique des modifications",
  {
    nombre: z
      .number()
      .optional()
      .default(5)
      .describe("Nombre de commits à afficher (défaut: 5)"),
  },
  async ({ nombre }) => {
    try {
      const commits = await githubApi(
        `/commits?sha=${GITHUB_BRANCH}&per_page=${nombre}`
      );
      const summary = commits.map((c) => {
        const date = new Date(c.commit.author.date).toLocaleString("fr-FR");
        return `- ${date}: ${c.commit.message} (${c.sha.slice(0, 7)})`;
      });
      return {
        content: [
          {
            type: "text",
            text: `Derniers commits:\n\n${summary.join("\n")}`,
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

// --- Start server ---

const transport = new StdioServerTransport();
await server.connect(transport);
