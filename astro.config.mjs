// @ts-check
import { defineConfig } from 'astro/config';
import tailwindcss from '@tailwindcss/vite';
import sitemap from '@astrojs/sitemap';

export default defineConfig({
  site: 'https://lordahou.github.io',
  base: '/camping-menil',
  vite: {
    plugins: [tailwindcss()],
  },
  integrations: [
    sitemap({
      changefreq: 'weekly',
      priority: 0.7,
    }),
  ],
  compressHTML: true,
  build: {
    inlineStylesheets: 'auto',
  },
});
