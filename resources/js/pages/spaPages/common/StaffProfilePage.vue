<template>
    <div class="spa">
        <NavigationObj />
        <main><HeaderObj /> <StaffProfileObj /></main>
    </div>
</template>

<script>
import NavigationObj from "@/components/spaObjects/system/NavigationObj.vue";
import HeaderObj from "@/components/spaObjects/system/HeaderObj.vue";
import StaffProfileObj from "@/components/spaObjects/profiles/StaffProfileObj.vue";

export default {
    components: {
        NavigationObj,
        HeaderObj,
        StaffProfileObj,
    },
    data() {},
};
</script>

<style lang="scss">
@import "/resources/css/spaStyle.css";
</style>
