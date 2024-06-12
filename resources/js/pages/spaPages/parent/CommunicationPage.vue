<template>
    <div class="spa">
        <NavigationObj />
        <main :key="mainKey">
            <HeaderObj />
            <CommunicationObj @refresh-main="refreshMain" />
        </main>
    </div>
</template>

<script>
import NavigationObj from "@/components/spaObjects/system/NavigationObj.vue";
import HeaderObj from "@/components/spaObjects/system/HeaderObj.vue";
import CommunicationObj from "@/components/spaObjects/CommunicationObj.vue";

export default {
    components: {
        NavigationObj,
        HeaderObj,
        CommunicationObj,
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
