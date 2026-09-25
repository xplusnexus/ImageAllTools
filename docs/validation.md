# Validation report

This sandbox has no network access (`npm install` cannot reach the npm
registry), so a real `astro build` could not be run here. What was
actually verified instead:

## 1. Content collection schema validation
All 47 files in `src/content/tools/` were parsed and checked against the
required field list (`title`, `description`, `h1`, `keyword`, `category`,
`engine`, `relatedTools`, `faqs`) and against the enum constraints
(`category` ∈ optimize/create/edit/convert/security, `engine` ∈
client/server).

**Result: 0 errors, 0 warnings** across all 47 files.

## 2. Internal link integrity
Every `relatedTools` slug in every file was checked against the actual
set of 47 filenames, to catch links to tools that don't exist yet.

**Result: 0 broken references.**

## 3. On-page SEO thresholds
Every `title` checked against the ≤60-char soft limit, every
`description` against ≤155 chars, every `faqs` array checked for ≥3
entries (for FAQPage rich-snippet eligibility).

**Result: all 47 files pass.**

## 4. Astro/JSX syntax sanity check
Every `.astro` file scanned for balanced `{ }` (a common source of
silent Astro compile failures) and a properly closed `---` frontmatter
fence.

**Result: no mismatches found in any of the 10 component/layout/page
files.**

## What this does *not* guarantee
This is static analysis, not a compiler. It cannot catch: TypeScript type
errors, incorrect Astro-specific syntax the linter above doesn't model,
missing npm dependencies, or runtime errors in the (not-yet-written)
engine JavaScript. Run `npm install && npm run build` in an environment
with network access before treating this as launch-ready.
