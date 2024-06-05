<template>
    <NavbarObj />
    <SideHeaderObj />
    <LocationObj />
    <FooterObj />
    <BackToTopObj />
</template>

<script>
import NavbarObj from "@/components/visitCardObjects/system/NavbarObj.vue";
import SideHeaderObj from "@/components/visitCardObjects/system/SideHeaderObj.vue";
import LocationObj from "@/components/visitCardObjects/LocationObj.vue";
import FooterObj from "@/components/visitCardObjects/system/FooterObj.vue";
import BackToTopObj from "@/components/visitCardObjects/system/BackToTopObj.vue";

export default {
    components: {
        NavbarObj,
        FooterObj,
        SideHeaderObj,
        LocationObj,
        BackToTopObj,
    },
    data() {},
};
</script>

<style scoped>
@import "/resources/css/app.css";
</style>
