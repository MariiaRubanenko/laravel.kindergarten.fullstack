<template>
    <div class="spa">
        <NavigationObj />
        <main :key="mainKey">
            <HeaderObj />
            <FeedbackSendObj @refresh-main="refreshMain" />
        </main>
    </div>
</template>

<script>
import NavigationObj from "@/components/spaObjects/system/NavigationObj.vue";
import HeaderObj from "@/components/spaObjects/system/HeaderObj.vue";
import FeedbackSendObj from "@/components/spaObjects/FeedbackSendObj.vue";

export default {
    components: {
        NavigationObj,
        HeaderObj,
        FeedbackSendObj,
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
