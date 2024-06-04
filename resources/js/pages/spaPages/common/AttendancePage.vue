<template>
    <div class="spa">
        <NavigationObj />
        <main>
            <HeaderObj />
            <AttendanceObj />
        </main>
    </div>
</template>

<script>
import NavigationObj from "@/components/spaObjects/system/NavigationObj.vue";
import HeaderObj from "@/components/spaObjects/system/HeaderObj.vue";
import AttendanceObj from "@/components/spaObjects/groupAtributes/AttendanceObj.vue";

export default {
    components: {
        NavigationObj,
        HeaderObj,
        AttendanceObj,
    },
    data() {},
};
</script>

<style lang="scss">
@import "/resources/css/spaStyle.css";
</style>
