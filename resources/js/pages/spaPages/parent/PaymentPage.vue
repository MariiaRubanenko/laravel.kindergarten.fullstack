<template>
    <div class="spa">
        <NavigationObj />
        <main>
            <HeaderObj />
            <FamilyPaymentsObj />
        </main>
    </div>
</template>

<script>
import NavigationObj from "@/components/spaObjects/system/NavigationObj.vue";
import HeaderObj from "@/components/spaObjects/system/HeaderObj.vue";
import FamilyPaymentsObj from "@/components/spaObjects/payment/FamilyPaymentsObj.vue";

export default {
    components: {
        NavigationObj,
        HeaderObj,
        FamilyPaymentsObj,
    },
    data() {},
};
</script>

<style lang="scss">
@import "/resources/css/spaStyle.css";
</style>
