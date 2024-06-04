<template>
    <!-- Header Start -->
    <div class="container-fluid bg-primary mb-5">
        <div
            class="d-flex flex-column align-items-center justify-content-center position-relative"
            style="min-height: 400px"
        >
            <img
                src="@/assets/img/header_background.png"
                class="position-absolute top-0 start-0 w-100 h-100"
                style="object-fit: cover; opacity: 0.4"
                alt=""
            />
            <h3 class="display-3 font-weight-bold text-container">
                {{ $t("sideHeader." + getPageTitle) }}
            </h3>
            <div class="d-inline-flex text-container">
                <p class="m-0">
                    <router-link to="/" class="text-container">{{
                        $t("sideHeader.Home")
                    }}</router-link>
                </p>
                <p class="m-0 px-2">/</p>
                <p class="m-0">{{ $t("sideHeader." + getPageTitle) }}</p>
            </div>
        </div>
    </div>
    <!-- Header End -->
</template>

<script>
export default {
    computed: {
        getPageTitle() {
            return this.$route.name === "Home"
                ? "Home"
                : this.$route.name || "Page";
        },
    },
};
</script>

<style></style>
