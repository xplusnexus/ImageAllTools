/** @type {import('tailwindcss').Config} */
export default {
  content: ["./src/**/*.{astro,html,md,mdx,js,ts}"],
  theme: {
    extend: {
      colors: {
        bg: "#0a0b0f",
        surface: {
          DEFAULT: "#12141c",
          2: "#171a24",
        },
        border: "#232634",
        cyan: {
          DEFAULT: "#26e0ff",
          500: "#26e0ff",
        },
        purple: {
          DEFAULT: "#a76bff",
          500: "#a76bff",
        },
        text: {
          DEFAULT: "#e7eaf3",
          muted: "#8b93a8",
        },
        ink: {
          DEFAULT: "#e7eaf3",
          muted: "#8b93a8",
        },
        brand: {
          50: "rgba(38, 224, 255, 0.08)",
          100: "#232634",
          500: "#26e0ff",
          600: "#26e0ff",
          700: "#a76bff",
          900: "#12141c",
        },
      },
      borderRadius: {
        card: "14px",
        pill: "999px",
      },
      fontFamily: {
        sans: ["Inter", "system-ui", "-apple-system", "sans-serif"],
        display: ["'Space Grotesk'", "system-ui", "-apple-system", "sans-serif"],
      },
    },
  },
  plugins: [],
};
