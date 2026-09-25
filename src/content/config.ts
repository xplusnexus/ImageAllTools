import { defineCollection, z } from "astro:content";

// Every tool page is one entry in this collection. Astro's dynamic route
// (src/pages/tools/[...slug].astro) generates one static HTML page per
// entry at build time — no server, no CMS, no Sanity.
const tools = defineCollection({
  type: "content",
  schema: z.object({
    // --- SEO / on-page fields (see spec §5) ---
    title: z.string(),                 // <title> tag, <=60 chars ideally
    description: z.string(),           // meta description, <=155 chars
    h1: z.string(),                    // on-page H1 (can differ slightly from <title>)
    keyword: z.string(),               // primary target keyword, for internal QA only
    category: z.enum(["optimize", "create", "edit", "convert", "security"]),

    // --- engine wiring ---
    // "client" = 100% browser-side (Canvas/WASM), no network call.
    // "server" = calls the Node MVC API (background-remove, upscale, ocr, html-to-image).
    engine: z.enum(["client", "server"]),
    engineModule: z.string().optional(), // e.g. "resize.js" — maps to src/engines/*

    // --- internal linking (SEO §5.3) ---
    relatedTools: z.array(z.string()).default([]), // slugs of 4-6 related tools

    // --- structured data (SEO §5.5) ---
    faqs: z
      .array(z.object({ q: z.string(), a: z.string() }))
      .default([]),

    // Whether this entry has full unique article content yet.
    // Lets the build/README flag stub pages that still need copy.
    status: z.enum(["complete", "stub"]).default("stub"),

    // Badge row shown under the H1 — matches your uploaded HTML reference.
    badges: z
      .array(z.string())
      .default(["100% Free", "Secure & Private", "Instant Processing", "Works on Mobile"]),
  }),
});

export const collections = { tools };
