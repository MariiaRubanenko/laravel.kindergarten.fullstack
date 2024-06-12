<template>
    <div class="spa">
        <NavigationObj />
        <main :key="mainKey">
            <HeaderObj />
            <div class="d-lg-flex justify-content-center">
                <div
                    class="col-lg-5 mb-5 mr-lg-5 mb-lg-0 mr-lg-3 fullscreen-container"
                >
                    <ChildrenOfGroupObj @refresh-main="refreshMain" />
                </div>
                <div class="col-lg-5 fullscreen-container">
                    <ChildrenWithoutGroupObj @refresh-main="refreshMain" />
                </div>
            </div>
        </main>
    </div>
</template>

<script>
import NavigationObj from "@/components/spaObjects/system/NavigationObj.vue";
import HeaderObj from "@/components/spaObjects/system/HeaderObj.vue";
import ChildrenOfGroupObj from "@/components/spaObjects/groupAtributes/ChildrenOfGroupObj.vue";
import ChildrenWithoutGroupObj from "@/components/spaObjects/groupAtributes/ChildrenWithoutGroupObj.vue";

export default {
    components: {
        NavigationObj,
        HeaderObj,
        ChildrenOfGroupObj,
        ChildrenWithoutGroupObj,
    },
    data() {
        return { mainKey: 0, groupId: this.$route.params.groupId };
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
