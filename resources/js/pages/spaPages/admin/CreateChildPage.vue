<template>
    <div class="spa">
        <NavigationObj />
        <main>
            <HeaderObj />
            <CreateChildObj :familyId="familyId" />
        </main>
    </div>
</template>

<script>
import NavigationObj from "@/components/spaObjects/system/NavigationObj.vue";
import HeaderObj from "@/components/spaObjects/system/HeaderObj.vue";
import CreateChildObj from "@/components/spaObjects/administration/CreateChildObj.vue";

export default {
    components: {
        NavigationObj,
        HeaderObj,
        CreateChildObj,
    },
    props: {
        familyId: {
            type: Number,
            required: true,
        },
    },
    data() {},
};
</script>

<style lang="scss">
@import "/resources/css/spaStyle.css";
</style>
