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
.family-buttons {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;

    .btn {
        flex: 1 1 calc(33.333% - 1rem); /* Adjust width for 3 buttons per row and add some margin */
        margin-right: 0.5rem;
        margin-left: 0.5rem;
        @media (max-width: 600px) {
            flex: 1 1 100%; /* Full width for smaller screens */
        }
    }
}
</style>
