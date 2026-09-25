# ImageAllTools — Astro-only build (no Sanity)

Astro Content Collections replace Sanity entirely. Every tool page is one
Markdown file in `src/content/tools/` — add a file, get a URL, no CMS,
no external account, no build-time API call.

## What's actually in this scaffold

✅ **Real, working Astro source** — layouts, components, dynamic routing,
SEO schema (FAQPage/BreadcrumbList/WebApplication), sitemap/robots config,
Tailwind tokens.

✅ **47 tool content files**, validated (see `docs/validation.md`):
- **15 fully written**, using the actual article content you provided
  earlier in this conversation (Image Resizer, Compressor, Cropper, the
  five platform resizers, Screenshot Beautifier, HTML to Image, WhatsApp
  DP Maker, Blur Image, Add Text to Image, and the two exact-dimension
  resizers).
- **32 started as shorter "stub" entries** (`status: "stub"` in
  frontmatter) — real, working, non-duplicate copy for every other tool
  in the catalog, but shorter than the SEO spec's 800+ word target. Treat
  these as a first draft to expand before you rely on them to rank —
  see "Before you launch" below.

⚠️ **Not included** (out of scope for this pass, flagged honestly):
- The actual pixel-processing JavaScript (resize/compress/crop/convert
  math, Canvas drawing, WASM codecs) — `ToolWidget.astro` is a wired-up
  placeholder; see `src/engines/README.md`.
- `npm install` / a working `dist/` build — this sandbox has no network
  access, so dependencies were never actually installed here. Every file
  was validated by hand instead (frontmatter schema, internal link
  integrity, brace-matching) — see `docs/validation.md` for the results.
  Run `npm install && npm run build` yourself to get a real build.
- The Node MVC API (`apps/api`) for the 4 server-backed tools
  (background-remove, ai-upscale, image-to-text, html-to-image) — folder
  structure is specified in the earlier PDF spec, not scaffolded here.

## How to add or finish a tool page

1. Create `src/content/tools/your-tool-slug.md`.
2. Fill in the frontmatter (see any existing file for the shape — it's
   enforced by `src/content/config.ts`, so a typo or missing field fails
   the build with a clear error).
3. Write the article body in Markdown below the closing `---`.
4. That's it — `src/pages/[...slug].astro` picks it up automatically at
   `https://yoursite.com/your-tool-slug`, with breadcrumbs, FAQ schema,
   related-tools linking, and the privacy notice all generated for free.

No other file needs to change to add a 48th tool.

## Deploying to Hostinger (only — no Vercel/Cloudflare/Railway)

1. `npm install && npm run build` → produces a static `dist/` folder.
2. Upload `dist/`'s contents to your Hostinger hosting plan's `public_html`
   via SFTP (hPanel → Files → FTP Accounts for credentials), or automate
   this with a GitHub Actions SFTP-deploy step (e.g.
   `SamKirkland/FTP-Deploy-Action`) triggered on push to `main`.
3. Enable Hostinger's free SSL and built-in CDN for the domain in hPanel —
   both are included on Business/Cloud plans.
4. The 4 server-backed tools (`background-remover`, `ai-image-upscaler`,
   `image-to-text`, `html-to-image` — see their frontmatter `engine:
   "server"`) need `apps/api` running somewhere with a persistent Node
   process, which shared hosting doesn't provide — that goes on a
   Hostinger VPS (PM2 + Nginx), not this static site. See
   `docs/imagealltools_spec.pdf` §8 for the full VPS setup and an honest
   note on the one thing Hostinger can't host: GPU/AI inference.

## Before you launch — content checklist

- [ ] Expand all 32 `status: "stub"` articles to 800+ unique words each
      (per SEO spec §5.4 — thin/near-duplicate content is the single
      biggest ranking risk for a tool-farm-shaped site).
- [ ] Replace the placeholder color tokens in `tailwind.config.mjs` with
      your real brand hex codes (see the comment in that file).
- [ ] Wire up real engines in `src/engines/` per that folder's README.
- [ ] Run `npm install && npm run build` locally/in CI to confirm the
      build actually compiles — this sandbox couldn't verify that step.
- [ ] Update `astro.config.mjs`'s `site` field to your real domain before
      the sitemap/canonical URLs are correct.

## Design tokens

Your original brief said to match "the uploaded HTML demo" — that upload
was plain text content (article copy, badge labels, nav structure), not
CSS, so no hex codes were available to extract. Colors in
`tailwind.config.mjs` are a reasonable blue-accent/light-background
approximation flagged as `[Implementation recommendation]` — swap them
for your real brand colors in one place and every one of the 47 pages
updates automatically.
