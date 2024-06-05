<template>
    <div class="spa">
        <NavigationObj />
        <main>
            <HeaderObj />
            <SwitchLanguageObj />
            <PasswordChangingObj />
        </main>
    </div>
</template>

<script>
import NavigationObj from "@/components/spaObjects/system/NavigationObj.vue";
import HeaderObj from "@/components/spaObjects/system/HeaderObj.vue";
import SwitchLanguageObj from "@/components/spaObjects/settings/SwitchLanguageObj.vue";
import PasswordChangingObj from "@/components/spaObjects/settings/PasswordChangingObj.vue";

export default {
    components: {
        NavigationObj,
        HeaderObj,
        SwitchLanguageObj,
        PasswordChangingObj,
    },
    data() {},
};
</script>

<style lang="scss">
@import "/resources/css/spaStyle.css";
</style>
