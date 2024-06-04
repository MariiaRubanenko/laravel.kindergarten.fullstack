<template>
    <NavbarObj />
    <HomeHeaderObj />
    <AboutObj />
    <ActivitiesObj />
    <ClassesObj />
    <TeachersObj />
    <FooterObj />
    <BackToTopObj />
</template>

<script>
import NavbarObj from "@/components/visitCardObjects/system/NavbarObj.vue";
import HomeHeaderObj from "@/components/visitCardObjects/system/HomeHeaderObj.vue";
import AboutObj from "@/components/visitCardObjects/home/AboutObj.vue";
import ActivitiesObj from "@/components/visitCardObjects/home/ActivitiesObj.vue";
import ClassesObj from "@/components/visitCardObjects/home/ClassesObj.vue";
import TeachersObj from "@/components/visitCardObjects/home/TeachersObj.vue";
import FooterObj from "@/components/visitCardObjects/system/FooterObj.vue";
import BackToTopObj from "@/components/visitCardObjects/system/BackToTopObj.vue";

export default {
    components: {
        NavbarObj,
        HomeHeaderObj,
        FooterObj,
        AboutObj,
        ActivitiesObj,
        ClassesObj,
        TeachersObj,
        BackToTopObj,
    },
    data() {},
};
</script>

<style scoped>
@import "/resources/css/app.css";
</style>
