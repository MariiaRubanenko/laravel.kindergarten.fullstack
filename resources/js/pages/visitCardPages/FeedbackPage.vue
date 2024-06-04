<template>
    <NavbarObj />
    <SideHeaderObj />
    <FeedbackObj />
    <FooterObj />
    <BackToTopObj />
</template>

<script>
import NavbarObj from "@/components/visitCardObjects/system/NavbarObj.vue";
import SideHeaderObj from "@/components/visitCardObjects/system/SideHeaderObj.vue";
import FeedbackObj from "@/components/visitCardObjects/FeedbackObj.vue";
import FooterObj from "@/components/visitCardObjects/system/FooterObj.vue";
import BackToTopObj from "@/components/visitCardObjects/system/BackToTopObj.vue";

export default {
    components: {
        NavbarObj,
        SideHeaderObj,
        FeedbackObj,
        BackToTopObj,
        FooterObj,
    },
    data() {},
};
</script>

<style scoped>
@import "/resources/css/app.css";
</style>
