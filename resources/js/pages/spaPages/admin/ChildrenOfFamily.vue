<template>
    <div class="spa">
        <NavigationObj />
        <main :key="mainKey">
            <HeaderObj />
            <ChildrenOfFamilyObj @refresh-main="refreshMain" />
        </main>
    </div>
</template>

<script>
import NavigationObj from "@/components/spaObjects/system/NavigationObj.vue";
import HeaderObj from "@/components/spaObjects/system/HeaderObj.vue";
import ChildrenOfFamilyObj from "@/components/spaObjects/familyAtributes/ChildrenOfFamilyObj.vue";

export default {
    components: {
        NavigationObj,
        HeaderObj,
        ChildrenOfFamilyObj,
    },
    data() {
        return { mainKey: 0, familyId: this.$route.params.familyId };
    },
    methods: {
        refreshMain() {
            this.mainKey++;
        },
    },
};
</script>

<style lang="scss">
@import "/resources/css/spaStyle.css";
</style>
