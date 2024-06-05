<template>
    <div class="spa">
        <NavigationObj />
        <main><UserProfileObj /></main>
    </div>
</template>

<script>
import NavigationObj from "@/components/spaObjects/system/NavigationObj.vue";
import UserProfileObj from "@/components/spaObjects/profiles/UserProfileObj.vue";

export default {
    components: {
        NavigationObj,
        UserProfileObj,
    },
    data() {},
};
</script>

<style lang="scss">
@import "/resources/css/spaStyle.css";
</style>
