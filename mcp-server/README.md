# Commune de Ménil — Serveur MCP WordPress

Serveur MCP (Model Context Protocol) pour gérer le site WordPress **www.menil53.fr** depuis votre smartphone via l'application Claude.

## Prérequis

- Node.js 18+
- Un compte **administrateur** ou **éditeur** sur le WordPress de menil53.fr
- Un **mot de passe d'application** WordPress

### Créer un mot de passe d'application WordPress

1. Connectez-vous à **www.menil53.fr/wp-admin**
2. Allez dans **Utilisateurs → Votre profil**
3. Descendez jusqu'à la section **« Mots de passe d'application »**
4. Entrez un nom : `MCP Smartphone`
5. Cliquez sur **« Ajouter un mot de passe d'application »**
6. **Copiez le mot de passe généré** (il ne sera plus affiché)

> Note : Les mots de passe d'application sont disponibles depuis WordPress 5.6. Si vous ne voyez pas cette section, demandez à votre hébergeur ou installez le plugin "Application Passwords".

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
    "menil53": {
      "command": "node",
      "args": ["/chemin/vers/camping-menil/mcp-server/index.js"],
      "env": {
        "WP_URL": "https://www.menil53.fr",
        "WP_USER": "votre_identifiant_wordpress",
        "WP_APP_PASSWORD": "xxxx xxxx xxxx xxxx xxxx xxxx"
      }
    }
  }
}
```

## Configuration pour Claude sur smartphone

Sur l'application mobile Claude, configurez un serveur MCP distant, ou utilisez Claude Desktop comme relais.

## Variables d'environnement

| Variable | Défaut | Description |
|----------|--------|-------------|
| `WP_URL` | `https://www.menil53.fr` | URL du site WordPress |
| `WP_USER` | *(requis)* | Identifiant WordPress (login) |
| `WP_APP_PASSWORD` | *(requis)* | Mot de passe d'application WordPress |

## Outils disponibles

### Consultation

| Outil | Description |
|-------|-------------|
| `infos_site` | Informations générales du site WordPress |
| `lister_articles` | Liste les articles (actualités, événements) |
| `lire_article` | Lit le contenu complet d'un article |
| `lister_pages` | Liste toutes les pages du site |
| `lire_page` | Lit le contenu complet d'une page |
| `lister_categories` | Liste les catégories d'articles |
| `lister_medias` | Liste les fichiers médias (images, PDFs) |
| `lister_commentaires` | Liste les commentaires récents |
| `lister_utilisateurs` | Liste les utilisateurs du site |

### Modification

| Outil | Description |
|-------|-------------|
| `creer_article` | Crée un nouvel article (brouillon ou publié) |
| `modifier_article` | Modifie un article (titre, contenu, statut) |
| `supprimer_article` | Supprime un article (corbeille ou définitif) |
| `modifier_page` | Modifie une page existante |
| `moderer_commentaire` | Approuve, refuse ou supprime un commentaire |

### Maintenance

| Outil | Description |
|-------|-------------|
| `verifier_mises_a_jour` | Vérifie les mises à jour plugins et thèmes |

## Exemples d'utilisation depuis votre smartphone

Une fois connecté, demandez simplement à Claude en français :

- *"Montre-moi les derniers articles du site de Ménil"*
- *"Crée un article annonçant la Fête du Pain le 15 juin"*
- *"Mets à jour la page du conseil municipal"*
- *"Quels commentaires sont en attente de modération ?"*
- *"Publie l'article brouillon sur l'agenda de l'été"*
- *"Y a-t-il des mises à jour de plugins à faire ?"*
- *"Liste les images du site"*

## Sécurité

- Le mot de passe d'application ne donne **pas accès au tableau de bord** WordPress
- Il est limité à l'API REST et peut être **révoqué** à tout moment depuis votre profil WordPress
- Les articles créés via MCP sont en **brouillon par défaut** — vous décidez quand publier
- Toutes les actions sont tracées dans WordPress avec votre identifiant
