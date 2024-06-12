<template>
    <div class="spa">
        <NavigationObj />
        <main :key="mainKey">
            <HeaderObj />
            <div class="row justify-content-center">
                <div class="col-lg-7 mb-5">
                    <ChildrenOfGroupObj @refresh-main="refreshMain" />
                </div>
            </div>
        </main>
    </div>
</template>

<script>
import NavigationObj from "@/components/spaObjects/system/NavigationObj.vue";
import HeaderObj from "@/components/spaObjects/system/HeaderObj.vue";

import ChildrenOfGroupObj from "@/components/spaObjects/groupAtributes/ChildrenOfGroupObj.vue";

export default {
    components: {
        NavigationObj,
        HeaderObj,
        ChildrenOfGroupObj,
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
