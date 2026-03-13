# Camping du Bac de Ménil — Site Web

Site internet premium du Camping Municipal du Bac, Ménil (53), Mayenne.

## Stack technique

- **Framework** : [Astro](https://astro.build/) v6 (static site generation)
- **CSS** : [Tailwind CSS](https://tailwindcss.com/) v4
- **Fonts** : DM Serif Display + Inter (Google Fonts)
- **SEO** : Sitemap auto, Schema.org, Open Graph, meta par page
- **Performance** : HTML statique, lazy loading, CSS inline, 0 framework JS

## Structure du projet

```
camping-menil/
├── public/
│   ├── images/          # Images du site (hero, hébergements, galerie...)
│   ├── favicon.svg      # Favicon SVG
│   └── robots.txt       # Configuration robots
├── src/
│   ├── components/      # Composants Astro réutilisables
│   │   ├── Header.astro
│   │   ├── Footer.astro
│   │   ├── Hero.astro
│   │   ├── SectionTitle.astro
│   │   ├── AccommodationCard.astro
│   │   ├── HighlightCard.astro
│   │   ├── ServiceIcon.astro
│   │   ├── PricingTable.astro
│   │   ├── Testimonials.astro
│   │   ├── FAQ.astro
│   │   ├── ContactForm.astro
│   │   └── CTABanner.astro
│   ├── data/
│   │   └── content.json # TOUT le contenu du site (textes, tarifs, FAQ...)
│   ├── layouts/
│   │   └── BaseLayout.astro  # Layout principal avec SEO et Schema.org
│   ├── pages/           # Pages du site (1 fichier = 1 page)
│   │   ├── index.astro
│   │   ├── le-camping.astro
│   │   ├── hebergements.astro
│   │   ├── services.astro
│   │   ├── tarifs.astro
│   │   ├── activites.astro
│   │   ├── galerie.astro
│   │   ├── infos-pratiques.astro
│   │   ├── contact.astro
│   │   ├── mentions-legales.astro
│   │   └── politique-confidentialite.astro
│   └── styles/
│       └── global.css   # Design system (couleurs, typographie, composants)
├── astro.config.mjs     # Configuration Astro + Tailwind + Sitemap
├── package.json
└── tsconfig.json
```

## Commandes

```bash
# Installation
npm install

# Développement (http://localhost:4321)
npm run dev

# Build production (dans ./dist/)
npm run build

# Prévisualisation du build
npm run preview
```

## Modifier le contenu

**Tout le contenu est centralisé dans `src/data/content.json`.**

Vous pouvez modifier directement ce fichier pour changer :
- Textes d'accueil et descriptions
- Tarifs
- Services et équipements
- Activités
- Horaires du Bac
- FAQ
- Témoignages
- Coordonnées et horaires d'ouverture
- Navigation et liens

### Modifier les images

Remplacez les fichiers dans `public/images/` en gardant les mêmes noms :
- `hero/camping-mayenne-hero.jpg` — Image principale (1920x1080 recommandé)
- `hebergements/` — Photos des hébergements
- `activites/` — Photos des activités
- `galerie/galerie-1.jpg` à `galerie-12.jpg` — Photos de la galerie

### Modifier les pages

Chaque page est un fichier `.astro` dans `src/pages/`. Vous pouvez modifier le HTML directement.

## Déploiement

### Option 1 : Hébergement statique (recommandé)

Le site génère des fichiers HTML statiques dans `./dist/`. Vous pouvez les déployer sur :
- **Netlify** : Connectez le repo Git, build command `npm run build`, publish dir `dist`
- **Vercel** : Auto-détection Astro, déploiement automatique
- **OVH / hébergeur classique** : Uploadez le contenu de `dist/` via FTP

### Option 2 : Sur serveur avec Apache/Nginx

```bash
npm run build
# Copiez le contenu de dist/ dans votre document root
```

### Configuration Apache (.htaccess)

```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ /$1/index.html [L]

# Cache images
<IfModule mod_expires.c>
  ExpiresActive On
  ExpiresByType image/jpeg "access plus 1 year"
  ExpiresByType image/png "access plus 1 year"
  ExpiresByType image/svg+xml "access plus 1 year"
  ExpiresByType text/css "access plus 1 month"
  ExpiresByType application/javascript "access plus 1 month"
</IfModule>

# Compression
<IfModule mod_deflate.c>
  AddOutputFilterByType DEFLATE text/html text/css application/javascript
</IfModule>
```

## Design System

### Couleurs

| Token         | Hex       | Usage                    |
|:------------- |:--------- |:------------------------ |
| `forest`      | `#1a3c2a` | Titres, header, footer   |
| `green`       | `#3a7d5c` | Boutons, liens, accents  |
| `sage`        | `#6db88a` | Icônes, badges, stars    |
| `moss`        | `#d4e8dc` | Fonds légers, badges     |
| `cream`       | `#faf8f4` | Fond principal           |
| `cream-dark`  | `#f0ece4` | Sections alternées       |
| `river`       | `#2a7ab5` | Accents eau/rivière      |

### Typographie

- **Titres** : DM Serif Display (serif élégant)
- **Corps** : Inter (sans-serif moderne)

## SEO

Le site est optimisé pour le référencement local :
- Structure sémantique HTML5
- Schema.org (Campground) sur toutes les pages
- Meta title/description par page
- Sitemap XML automatique
- Open Graph et Twitter Cards
- URLs propres et SEO-friendly

Mots-clés ciblés :
- camping Ménil, camping Mayenne
- camping bord de rivière Mayenne
- camping près de Château-Gontier
- hébergement touristique Ménil

## Licence

Site web du Camping Municipal du Bac — Commune de Ménil (53200)
