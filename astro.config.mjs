import { defineConfig } from "astro/config";
import tailwind from "@astrojs/tailwind";
import sitemap from "@astrojs/sitemap";
import mdx from "@astrojs/mdx";

// Astro-only build — no Sanity, no CMS. All tool copy lives in
// src/content/tools/*.md as Content Collections, versioned with the code.
export default defineConfig({
  site: "https://www.imagealltools.com",
  integrations: [tailwind(), sitemap(), mdx()],
  output: "static", // every tool page is pre-rendered at build time (SSG)
  build: {
    format: "directory", // /image-resizer/ instead of /image-resizer.html
  },
});
