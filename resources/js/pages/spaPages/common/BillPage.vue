<template>
    <div class="spa">
        <NavigationObj />
        <main>
            <HeaderObj />
            <BillObj />
        </main>
    </div>
</template>

<script>
import NavigationObj from "@/components/spaObjects/system/NavigationObj.vue";
import HeaderObj from "@/components/spaObjects/system/HeaderObj.vue";
import BillObj from "@/components/spaObjects/payment/BillObj.vue";

export default {
    components: {
        NavigationObj,
        HeaderObj,
        BillObj,
    },
    data() {},
};
</script>

<style lang="scss">
@import "/resources/css/spaStyle.css";
</style>
