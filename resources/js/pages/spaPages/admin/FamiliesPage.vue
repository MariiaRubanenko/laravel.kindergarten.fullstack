<template>
    <div class="spa">
        <NavigationObj />
        <main><HeaderObj /> <FamiliesObj /></main>
    </div>
</template>

<script>
import NavigationObj from "@/components/spaObjects/system/NavigationObj.vue";
import HeaderObj from "@/components/spaObjects/system/HeaderObj.vue";
import FamiliesObj from "@/components/spaObjects/administration/FamiliesObj.vue";

export default {
    components: {
        NavigationObj,
        HeaderObj,
        FamiliesObj,
    },
    data() {},
};
</script>

<style lang="scss">
@import "/resources/css/spaStyle.css";
</style>
