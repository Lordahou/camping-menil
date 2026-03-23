# Camping du Bac de Ménil — Serveur MCP

Serveur MCP (Model Context Protocol) pour gérer le contenu du site du Camping du Bac de Ménil depuis n'importe quel client compatible (Claude sur smartphone, Claude Desktop, etc.).

## Prérequis

- Node.js 18+
- Un **token GitHub** avec les permissions `repo` (pour lire/écrire le contenu)

### Créer un token GitHub

1. Allez sur https://github.com/settings/tokens
2. Cliquez sur **"Generate new token (classic)"**
3. Donnez un nom : `camping-menil-mcp`
4. Cochez la permission **`repo`** (Full control of private repositories)
5. Générez et copiez le token

## Installation

```bash
cd mcp-server
npm install
```

## Configuration pour Claude Desktop (PC/Mac)

Ajoutez ceci dans votre fichier de configuration Claude Desktop :

- **macOS** : `~/Library/Application Support/Claude/claude_desktop_config.json`
- **Windows** : `%APPDATA%\Claude\claude_desktop_config.json`

```json
{
  "mcpServers": {
    "camping-menil": {
      "command": "node",
      "args": ["/chemin/vers/camping-menil/mcp-server/index.js"],
      "env": {
        "GITHUB_TOKEN": "ghp_votre_token_ici"
      }
    }
  }
}
```

## Configuration pour Claude sur smartphone (iOS/Android)

Sur l'application mobile Claude, allez dans **Paramètres → Serveurs MCP** et ajoutez un serveur distant, ou utilisez Claude Desktop comme relais.

Alternativement, vous pouvez déployer le serveur sur un VPS (ex: serveur à 5€/mois) et le configurer en tant que serveur MCP distant.

## Variables d'environnement

| Variable | Défaut | Description |
|----------|--------|-------------|
| `GITHUB_TOKEN` | *(requis)* | Token d'accès GitHub |
| `GITHUB_OWNER` | `Lordahou` | Propriétaire du dépôt |
| `GITHUB_REPO` | `camping-menil` | Nom du dépôt |
| `GITHUB_BRANCH` | `main` | Branche cible |

## Outils disponibles

### Consultation
| Outil | Description |
|-------|-------------|
| `lister_sections` | Liste toutes les sections modifiables du site |
| `lire_section` | Lit le contenu d'une section spécifique |
| `derniers_commits` | Affiche les derniers commits |
| `statut_deploiement` | Vérifie le statut du déploiement GitHub Actions |

### Modification
| Outil | Description |
|-------|-------------|
| `modifier_section` | Remplace entièrement une section |
| `modifier_champ` | Modifie un champ spécifique (ex: un prix, un téléphone) |
| `ajouter_element` | Ajoute un élément à une section (ex: un témoignage, une FAQ) |
| `supprimer_element` | Supprime un élément d'une section par son index |

### Sections modifiables

`site`, `contact`, `openingDates`, `hero`, `highlights`, `accommodations`, `services`, `activities`, `surroundings`, `bac`, `tarifs`, `testimonials`, `faq`, `navigation`, `footerLinks`

## Exemples d'utilisation avec Claude

Une fois connecté, vous pouvez demander à Claude en langage naturel :

- *"Montre-moi les tarifs actuels du camping"*
- *"Change le numéro de téléphone en 02 43 70 XX XX"*
- *"Ajoute un nouveau témoignage de Marie D. avec 5 étoiles"*
- *"Mets à jour les dates d'ouverture pour la saison 2027"*
- *"Ajoute une question FAQ sur les vélos électriques"*
- *"Quel est le statut du dernier déploiement ?"*

Chaque modification est automatiquement commitée sur GitHub et déclenche un redéploiement du site.
