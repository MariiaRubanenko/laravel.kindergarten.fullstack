<template>
    <div class="spa">
        <NavigationObj />
        <main>
            <HeaderObj />
            <FamilyAccountProfileObj /> <TrustedPersonsObj />
        </main>
    </div>
</template>

<script>
import NavigationObj from "@/components/spaObjects/system/NavigationObj.vue";
import HeaderObj from "@/components/spaObjects/system/HeaderObj.vue";
import TrustedPersonsObj from "@/components/spaObjects/familyAtributes/TrustedPersonsObj.vue";
import FamilyAccountProfileObj from "@/components/spaObjects/familyAtributes/FamilyAccountProfileObj.vue";
export default {
    components: {
        NavigationObj,
        HeaderObj,
        TrustedPersonsObj,
        FamilyAccountProfileObj,
    },
    data() {},
};
</script>

<style lang="scss">
@import "/resources/css/spaStyle.css";
</style>
