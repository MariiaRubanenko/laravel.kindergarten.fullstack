<template>
    <div class="spa">
        <NavigationObj />
        <main>
            <HeaderObj />
            <ChildProfileObj />
        </main>
    </div>
</template>

<script>
import NavigationObj from "@/components/spaObjects/system/NavigationObj.vue";
import HeaderObj from "@/components/spaObjects/system/HeaderObj.vue";
import ChildProfileObj from "@/components/spaObjects/profiles/ChildProfileObj.vue";

export default {
    components: {
        NavigationObj,
        HeaderObj,
        ChildProfileObj,
    },
    data() {},
};
</script>

<style lang="scss">
@import "/resources/css/spaStyle.css";
</style>
