<template>
    <div class="spa">
        <NavigationObj />
        <main :key="mainKey">
            <HeaderObj />
            <div class="d-lg-flex justify-content-center">
                <div
                    class="col-lg-5 mb-5 mr-lg-5 mb-lg-0 mr-lg-3 fullscreen-container"
                >
                    <StaffsOfGroupObj @refresh-main="refreshMain" />
                </div>
                <div class="col-lg-5 fullscreen-container">
                    <StaffsWithoutGroupObj @refresh-main="refreshMain" />
                </div>
            </div>
        </main>
    </div>
</template>

<script>
import NavigationObj from "@/components/spaObjects/system/NavigationObj.vue";
import HeaderObj from "@/components/spaObjects/system/HeaderObj.vue";
import StaffsOfGroupObj from "@/components/spaObjects/groupAtributes/StaffsOfGroupObj.vue";
import StaffsWithoutGroupObj from "@/components/spaObjects/groupAtributes/StaffWithoutGroupObj.vue";

export default {
    components: {
        NavigationObj,
        HeaderObj,
        StaffsOfGroupObj,
        StaffsWithoutGroupObj,
    },
    data() {
        return { mainKey: 0 };
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
