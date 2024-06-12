<template>
    <div class="spa">
        <NavigationObj />
        <main :key="mainKey">
            <UserProfileObj
                @refresh-main="refreshMain"
                :refresh-main="refreshMain"
            />
        </main>
    </div>
</template>

<script>
import NavigationObj from "@/components/spaObjects/system/NavigationObj.vue";
import UserProfileObj from "@/components/spaObjects/profiles/UserProfileObj.vue";

export default {
    components: {
        NavigationObj,
        UserProfileObj,
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
