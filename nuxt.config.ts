// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: "2024-11-01",
  devtools: { enabled: true },
  css: ["assets/css/tailwind.css"],
  modules: [
    "@nuxtjs/tailwindcss",
    "shadcn-nuxt",
    "@nuxt/fonts",
    "@vueuse/nuxt",
    "nuxt-lucide-icons",
    "@nuxt/image",
  ],
  plugins: ["~/plugins/eventBus.ts"],
  components: [
    {
      path: "~/components",
      pathPrefix: false,
    },
  ],
  shadcn: {
    prefix: "",
    componentDir: "./components/ui",
  },
});
