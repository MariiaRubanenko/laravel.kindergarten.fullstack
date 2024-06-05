<template>
    <div class="spa">
        <NavigationObj />
        <main>
            <HeaderObj />
            <CommunicationObj />
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
    data() {},
};
</script>

<style lang="scss">
@import "/resources/css/spaStyle.css";
</style>
