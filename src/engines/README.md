# Tool engines

Each tool's real pixel-processing logic lives here as a plain JS module
(e.g. `resize.js`, `compress.js`, `crop.js`), loaded on-demand by
`ToolWidget.astro` only when a visitor actually opens that tool page —
not bundled into every page's JS payload.

This folder is intentionally empty in this scaffold. Wiring up the actual
Canvas/WebAssembly image-processing algorithms (resize interpolation,
JPEG/WebP encoding, crop math, blur convolution, etc.) is a separate
engineering task from the content/SEO/architecture scaffold this repo
covers. See docs/imagealltools_spec.pdf §3.1 for which tools are
client-side (`engine: "client"` in frontmatter) vs. server-backed
(`engine: "server"`, calling `/api/v1/*` in the companion `apps/api`).
