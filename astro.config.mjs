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
  redirects: {
    "/whatsapp-full-dp": "/whatsapp-dp-maker",
    "/full-dp-whatsapp": "/whatsapp-dp-maker",
    "/instagram-resizer": "/resize-image-for-instagram",
    "/resize-for-instagram": "/resize-image-for-instagram",
    "/instagram-post-size": "/resize-image-for-instagram",
    "/instagram-photo-size": "/resize-image-for-instagram",
    "/resize-image-for-facebook": "/resize-image-for-facebook-post",
    "/facebook-resizer": "/resize-image-for-facebook-post",
    "/facebook-cover-size": "/resize-image-for-facebook-post",
    "/facebook-profile-size": "/resize-image-for-facebook-post",
    "/facebook-profile-picture-size": "/resize-image-for-facebook-post",
    "/online-image-cropper": "/image-cropper",
    "/image-cropper-online": "/image-cropper",
    "/free-image-cropper": "/image-cropper",
    "/photo-cropper": "/image-cropper",
    "/picture-cropper": "/image-cropper",
    "/square-image-cropper": "/image-cropper",
    "/pfp-cropper": "/image-cropper",
    "/avatar-cropper": "/image-cropper",
    "/png-cropper": "/image-cropper",
    "/universal-image-cropper": "/image-cropper",
    "/remove-background": "/background-remover",
    "/free-background-remover": "/background-remover",
    "/online-background-remover": "/background-remover",
    "/background-remover-free": "/background-remover",
    "/background-remover-online": "/background-remover",
    "/bg-remover": "/background-remover",
    "/image-background-remover": "/background-remover",
    "/photo-background-remover": "/background-remover",
    "/transparent-background-remover": "/background-remover",
    "/white-background-remover": "/background-remover",
    "/instant-background-remover": "/background-remover",
    "/pixelcut-background-remover": "/background-remover",
    "/color-palette-generator": "/color-palette",
    "/palette-generator": "/color-palette",
    "/color-palette-from-image": "/color-palette",
    "/image-color-palette": "/color-palette",
    "/color-picker-from-image": "/color-palette",
    "/image-color-picker": "/color-palette",
    "/extract-colors-from-image": "/color-palette",
    "/seasonal-color-palette": "/color-palette",
    "/hex-color-palette": "/color-palette",
    "/coolers-color-palette": "/color-palette",
    "/photo-metadata-viewer": "/",
    "/remove-image-metadata": "/",
  },
});
