/** @type {import('tailwindcss').Config} */
export default {
  content: ["./src/**/*.{astro,html,md,mdx,js,ts}"],
  theme: {
    extend: {
      colors: {
        bg: "#0f1422",
        surface: {
          DEFAULT: "#171f33",
          2: "#1f2942",
        },
        border: "#2c3b59",
        cyan: {
          DEFAULT: "#26e0ff",
          500: "#26e0ff",
        },
        purple: {
          DEFAULT: "#a76bff",
          500: "#a76bff",
        },
        text: {
          DEFAULT: "#ffffff",
          muted: "#f1f5f9",
        },
        ink: {
          DEFAULT: "#ffffff",
          muted: "#f1f5f9",
        },
        brand: {
          50: "rgba(38, 224, 255, 0.12)",
          100: "#2c3b59",
          500: "#26e0ff",
          600: "#26e0ff",
          700: "#a76bff",
          900: "#171f33",
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
