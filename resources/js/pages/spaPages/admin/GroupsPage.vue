<template>
    <div class="spa">
        <NavigationObj />
        <main :key="mainKey">
            <HeaderObj />
            <CreateGroupObj @refresh-main="refreshMain" />
            <GroupsObj @refresh-main="refreshMain" />
        </main>
    </div>
</template>

<script>
import NavigationObj from "@/components/spaObjects/system/NavigationObj.vue";
import HeaderObj from "@/components/spaObjects/system/HeaderObj.vue";
import CreateGroupObj from "@/components/spaObjects/administration/CreateGroupObj.vue";
import GroupsObj from "@/components/spaObjects/administration/GroupsObj.vue";

export default {
    components: {
        NavigationObj,
        HeaderObj,
        CreateGroupObj,
        GroupsObj,
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
