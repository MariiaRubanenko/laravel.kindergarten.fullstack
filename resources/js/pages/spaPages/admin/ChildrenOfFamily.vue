<template>
    <div class="spa">
        <NavigationObj />
        <main><HeaderObj /> <ChildrenOfFamilyObj /></main>
    </div>
</template>

<script>
import NavigationObj from "@/components/spaObjects/system/NavigationObj.vue";
import HeaderObj from "@/components/spaObjects/system/HeaderObj.vue";
import ChildrenOfFamilyObj from "@/components/spaObjects/familyAtributes/ChildrenOfFamilyObj.vue";

export default {
    components: {
        NavigationObj,
        HeaderObj,
        ChildrenOfFamilyObj,
    },
    data() {
        return { familyId: this.$route.params.familyId };
    },
};
</script>

<style lang="scss">
@import "/resources/css/spaStyle.css";
</style>
