<template>
    <div class="spa">
        <NavigationObj />
        <main><HeaderObj /> <StaffsObj /></main>
    </div>
</template>

<script>
import NavigationObj from "@/components/spaObjects/system/NavigationObj.vue";
import HeaderObj from "@/components/spaObjects/system/HeaderObj.vue";
import StaffsObj from "@/components/spaObjects/administration/StaffsObj.vue";

export default {
    components: {
        NavigationObj,
        HeaderObj,
        StaffsObj,
    },
    data() {},
};
</script>

<style lang="scss">
@import "/resources/css/spaStyle.css";
</style>
