import "./bootstrap";
import { createApp } from "vue";
import router from "./router"; // Import the router
import EN from "@/locales/en.json";
import KM from "@/locales/km.json";
import { createI18n } from "vue-i18n";
import App from "./components/App.vue";

const i18n = createI18n({
    legacy: false,
    locale: "km",
    fallbackLocale: "en",
    messages: {
        en: EN,
        km: KM,
    },
});

const app = createApp(App); // Use App.vue as the root component
app.use(router);
app.use(i18n);
app.mount("#app");
