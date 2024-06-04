<template>
    <div class="spa">
        <NavigationObj />
        <main>
            <HeaderObj />
            <FeedbackSendObj />
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
    data() {},
};
</script>

<style lang="scss">
@import "/resources/css/spaStyle.css";
</style>
