---
title: "Blur Image Online — Hide Faces, Plates & Text"
description: "Paint over faces, license plates, or sensitive text to blur them instantly. Everything runs locally — images are never uploaded."
h1: "Blur Image — Protect Privacy in Photos"
keyword: "blur image online"
category: "security"
engine: "client"
engineModule: "blur.js"
status: "complete"
relatedTools:
  - "image-pixelator"
  - "watermark-remover"
  - "image-cropper"
  - "remove-image-metadata"
  - "background-remover"
faqs:
  - q: "Is it really free?"
    a: "Yes — no hidden costs, no watermarks, no usage limits."
  - q: "Are my images safe when I use this tool?"
    a: "Yes. Nothing is uploaded to any server. All processing happens locally via HTML5 Canvas — closing the tab removes all trace of the image."
  - q: "How is this different from pixelation?"
    a: "This tool uses Gaussian blur, which produces a smoother, more natural look than mosaic-style pixelation while being equally effective at hiding content. A dedicated pixelate mode is also available."
  - q: "Can I use this on mobile?"
    a: "Yes — full touch support for painting with your finger."
  - q: "Is the blur reversible?"
    a: "No — the blurred pixel data replaces the original in the downloaded file, making it suitable for privacy compliance and redaction."
---

Sharing photos online routinely exposes information you didn't mean to share — a stranger's face in the background, a visible license plate, personal documents on a desk. This tool lets you paint over exactly the areas you want hidden, entirely in your browser.

## How to blur an image

1. Upload your photo (JPG, PNG, WebP, BMP, or GIF — no file size limit, since nothing leaves your device).
2. Paint over the areas to hide — a brush-size circle follows your cursor or finger.
3. Adjust brush size (10–150px) and blur intensity (5–40px) to match the job.
4. Download as a high-quality PNG.

## Why blur images before sharing

- **Privacy regulation** — GDPR and CCPA require protecting identifiable individuals in publicly shared images; failing to blur faces can carry real penalties.
- **Protecting children** — blurring kids' faces before posting school or event photos is an increasingly standard precaution.
- **License plates** — real estate listings, car-for-sale posts, and street photography commonly need plates blurred to prevent vehicle tracking.
- **Screenshots** — redact emails, phone numbers, or financial data before sharing a screenshot in a support ticket or presentation.
- **Brand/competitor logos** — blur visible third-party trademarks in review or comparison content.

## How it works under the hood

A blurred copy of the whole image is pre-generated at your chosen intensity. Painting creates a mask — wherever you paint, the blurred version shows through instead of the sharp original. The composite happens in real time using the browser's native Canvas rendering.

## Pro tips

- Use a larger brush (80–120px) for faces and big areas, then fine-tune edges with a smaller brush.
- For genuine privacy redaction, set intensity to 30–40px so content is fully unrecognizable — lighter blur (5–15px) suits creative soft-focus effects instead.
- Zoom your browser in (Ctrl/Cmd + Plus) for precise work on small text in a screenshot.
- Use the undo history (up to 30 strokes) rather than restarting if a stroke goes slightly outside the target area.

## Common use cases

Real estate photography, e-commerce listings (hiding serial numbers or competitor branding), HR document redaction, journalism (protecting sources), and classroom photos shared on school websites.
