<template>
    <div class="spa">
        <NavigationObj />
        <main :key="mainKey">
            <HeaderObj />
            <div class="row justify-content-center">
                <div class="col-lg-7 mb-5">
                    <StaffsOfGroupObj @refresh-main="refreshMain" />
                </div>
            </div>
        </main>
    </div>
</template>

<script>
import NavigationObj from "@/components/spaObjects/system/NavigationObj.vue";
import HeaderObj from "@/components/spaObjects/system/HeaderObj.vue";
import StaffsOfGroupObj from "@/components/spaObjects/groupAtributes/StaffsOfGroupObj.vue";

export default {
    components: {
        NavigationObj,
        HeaderObj,
        StaffsOfGroupObj,
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
