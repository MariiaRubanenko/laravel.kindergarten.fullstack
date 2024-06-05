import { createApp } from "vue";
import App from "@/App.vue";
import router from "@/router/router.js";

import { createI18n, useI18n } from "vue-i18n";
import { languages } from "@/i18n";
import { defoltLocale } from "@/i18n";

import axios from "axios";
axios.defaults.headers.common["Content-Type"] = "application/json";
axios.defaults.headers.common["Accept"] = "application/json";

axios.defaults.headers.common["Access-Control-Allow-Origin"] = "*";
axios.defaults.withCredentials = true;
axios.defaults.baseURL = "http://localhost:8000/api/";

import { logout } from "@/api/request";

axios.interceptors.response.use(
    (response) => response, // Если ответ успешен, просто возвращаем его
    (error) => {
        if (
            error.response &&
            error.response.status === 401 &&
            error.response.data.message === "Unauthenticated."
        ) {
            // Если код ответа 401, вызываем функцию logout
            logout();
        } else if (error.response && error.response.status === 404) {
            router.push("/404");
        } else if (error.response && error.response.status === 500) {
            router.push("/500");
        }
        return Promise.reject(error); // Пробрасываем ошибку дальше
    }
);

const localStorageLang = localStorage.getItem("lang");
const messages = Object.assign(languages);

const app = createApp(App, {
    setup() {
        const { t } = useI18n();
        return { t };
    },
});

const i18n = createI18n({
    legacy: false,
    locale: localStorageLang || defoltLocale,
    fallbackLocale: "en",
    messages,
});

app.use(i18n).use(router).mount("#app");
