<template>
    <NavbarObj />
    <LogInObj />
    <BackToTopObj />
</template>

<script>
import NavbarObj from "@/components/visitCardObjects/system/NavbarObj.vue";
import LogInObj from "@/components/visitCardObjects/LogInObj.vue";
import BackToTopObj from "@/components/visitCardObjects/system/BackToTopObj.vue";

export default {
    components: {
        NavbarObj,
        LogInObj,
        BackToTopObj,
    },
    data() {},
};
</script>

<style scoped>
@import "/resources/css/app.css";
</style>
