<template>
    <div class="spa">
        <NavigationObj />
        <main>
            <HeaderObj />
            <SwitchLanguageObj />
            <PasswordChangingObj
                :key="passwordChangingKey"
                @refresh-password-changing="refreshPasswordChanging"
            />
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
    data() {
        return { passwordChangingKey: 0 };
    },
    methods: {
        refreshPasswordChanging() {
            this.passwordChangingKey++;
        },
    },
};
</script>

<style lang="scss">
@import "/resources/css/spaStyle.css";
</style>
