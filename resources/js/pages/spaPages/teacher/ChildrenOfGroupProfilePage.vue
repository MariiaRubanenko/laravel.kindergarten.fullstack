<template>
    <div class="spa">
        <NavigationObj />
        <main>
            <HeaderObj />
            <div class="row justify-content-center">
                <div class="col-lg-7 mb-5">
                    <ChildrenOfGroupObj />
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
    data() {},
};
</script>

<style lang="scss">
@import "/resources/css/spaStyle.css";
</style>
