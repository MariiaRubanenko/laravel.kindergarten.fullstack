<template>
    <div class="spa">
        <NavigationObj />
        <main :key="mainKey">
            <div class="d-lg-flex justify-content-center">
                <div class="col-lg-3 mb-5 mr-3 fullscreen-container order-lg-2">
                    <HeaderObj />
                    <LessonCreateObj
                        :key="lessonCreateKey"
                        @refresh-lessonCreate="refreshLessonCreate"
                        @refresh-timetable="refreshTimetable"
                    />
                    <ActivityCreateObj
                        :key="activityCreateKey"
                        @refresh-activityCreate="refreshActivityCreate"
                        @refresh-activityDelete="refreshActivityDelete"
                        @refresh-lessonCreate="refreshLessonCreate"
                    />
                    <ActivityDeleteObj
                        :key="activityDeleteKey"
                        @refresh-timetable="refreshTimetable"
                        @refresh-lessonCreate="refreshLessonCreate"
                        @refresh-activityDelete="refreshActivityDelete"
                        v-if="userRole === 'admin'"
                    />
                </div>
                <div class="col-lg-9 mb-5 mr-lg-3 mb-lg-0 mr-lg-3">
                    <TimetableObj
                        :key="timetableKey"
                        @refresh-main="refreshMain"
                    />
                </div>
            </div>
        </main>
    </div>
</template>

<script>
import NavigationObj from "@/components/spaObjects/system/NavigationObj.vue";
import HeaderObj from "@/components/spaObjects/system/HeaderObj.vue";

import LessonCreateObj from "@/components/spaObjects/timetable/LessonCreateObj.vue";
import ActivityCreateObj from "@/components/spaObjects/timetable/ActivityCreateObj.vue";
import ActivityDeleteObj from "@/components/spaObjects/timetable/ActivityDeleteObj.vue";

import TimetableObj from "@/components/spaObjects/timetable/TimetableObj.vue";

export default {
    components: {
        NavigationObj,
        HeaderObj,
        LessonCreateObj,
        ActivityCreateObj,
        ActivityDeleteObj,
        TimetableObj,
    },
    data() {
        return {
            userRole: localStorage.getItem("userRole"),
            timetableKey: 0,
            activityDeleteKey: 0,
            activityCreateKey: 0,
            lessonCreateKey: 0,
            mainKey: 0,
        };
    },
    methods: {
        refreshTimetable() {
            this.timetableKey++;
        },
        refreshActivityDelete() {
            this.activityDeleteKey++;
        },
        refreshActivityCreate() {
            this.activityCreateKey++;
        },
        refreshLessonCreate() {
            this.lessonCreateKey++;
        },
        refreshMain() {
            this.mainKey++;
        },
    },
};
</script>

<style lang="scss">
@import "/resources/css/spaStyle.css";
</style>
