<template>
    <!-- Navbar Start -->
    <div class="container-fluid bg-light position-relative shadow">
        <nav
            class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0 px-lg-5"
        >
            <a
                href=""
                class="navbar-brand font-weight-bold text-secondary"
                style="font-size: 40px"
            >
                <img
                    style="
                        width: 5rem;
                        margin-right: 0.5rem;
                        margin-bottom: 1rem;
                    "
                    src="@/assets/img/logo.png"
                    alt=""
                />
                <span class="text-primary">{{ $t("navBar.name") }}</span>
            </a>
            <button type="button" class="navbar-toggler" @click="toggleMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div
                class="collapse navbar-collapse justify-content-between"
                :class="{ show: menuOpen }"
            >
                <div class="navbar-nav font-weight-bold mx-auto py-0">
                    <router-link
                        :to="{ name: 'Home' }"
                        class="nav-item nav-link"
                        :class="{ active: currentPage === 'Home' }"
                        >{{ $t("navBar.pages.home") }}</router-link
                    >
                    <router-link
                        :to="{ name: 'Location' }"
                        class="nav-item nav-link"
                        :class="{ active: currentPage === 'Location' }"
                        >{{ $t("navBar.pages.location") }}</router-link
                    >
                    <router-link
                        :to="{ name: 'Feedback' }"
                        class="nav-item nav-link"
                        :class="{ active: currentPage === 'Feedback' }"
                        >{{ $t("navBar.pages.feedback") }}</router-link
                    >
                </div>
                <button
                    class="btn btn-link"
                    @click="setUkrLang"
                    style="font-size: 1rem; margin-right: 1rem"
                >
                    {{ $t("navBar.buttons.ua") }}
                </button>
                <button
                    class="btn btn-link"
                    @click="setEnglLang"
                    style="font-size: 1rem; margin-right: 1rem"
                >
                    {{ $t("navBar.buttons.eng") }}
                </button>
                <div class="pt-2">
                    <router-link to="/logIn" class="btn btn-primary px-4">{{
                        $t("navBar.buttons.logIn")
                    }}</router-link>
                </div>
            </div>
        </nav>
    </div>
    <!-- Navbar End -->
</template>

<script>
import { ref } from "vue";
import { useI18n } from "vue-i18n";

export default {
    computed: {
        currentPage() {
            // Return the name of the current route
            return this.$route.name;
        },
    },
    setup() {
        const { t, locale } = useI18n({ useScope: "global" });

        const setUkrLang = () => {
            locale.value = "ua";
            localStorage.setItem("lang", locale.value);
        };

        const setEnglLang = () => {
            locale.value = "en";
            localStorage.setItem("lang", locale.value);
        };

        const menuOpen = ref(false);

        const toggleMenu = () => {
            menuOpen.value = !menuOpen.value;
        };

        return { t, setUkrLang, setEnglLang, menuOpen, toggleMenu };
    },
};
</script>
