<template>
    <div class="spa">
        <NavigationObj />
        <main>
            <HeaderObj />
            <CreateUserObj />
        </main>
    </div>
</template>

<script>
import NavigationObj from "@/components/spaObjects/system/NavigationObj.vue";
import HeaderObj from "@/components/spaObjects/system/HeaderObj.vue";
import CreateUserObj from "@/components/spaObjects/administration/UserCreateObj.vue";

export default {
    components: {
        NavigationObj,
        HeaderObj,
        CreateUserObj,
    },
    data() {},
};
</script>

<style lang="scss">
@import "/resources/css/spaStyle.css";
</style>
