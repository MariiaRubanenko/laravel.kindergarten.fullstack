<template>
    <div class="spa">
        <NavigationObj />
        <main>
            <HeaderObj />
            <AppDownloadObj />
            <AboutAppObj />
        </main>
    </div>
</template>

<script>
import NavigationObj from "@/components/spaObjects/system/NavigationObj.vue";
import HeaderObj from "@/components/spaObjects/system/HeaderObj.vue";
import AppDownloadObj from "@/components/spaObjects/mobileApp/AppDownloadObj.vue";
import AboutAppObj from "@/components/spaObjects/mobileApp/AboutAppObj.vue";

export default {
    components: {
        NavigationObj,
        HeaderObj,
        AppDownloadObj,
        AboutAppObj,
    },
    data() {},
};
</script>

<style lang="scss">
@import "/resources/css/spaStyle.css";
</style>
