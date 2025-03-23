import "./bootstrap";
import { createApp } from "vue";
import router from "./router"; // Import the router
import EN from "@/locales/en.json";
import KM from "@/locales/km.json";
import { createI18n } from "vue-i18n";
import App from "./components/App.vue";
import Swal from "sweetalert2";

window.Swal = Swal;
const toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
    },
});
window.toast = toast;

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
