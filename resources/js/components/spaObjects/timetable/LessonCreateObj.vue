<template>
    <form @submit.prevent="createLesson" novalidate="novalidate">
        <h2 style="margin-bottom: 0.75rem">
            {{ $t("timetable.createLesson.title") }}
        </h2>
        <div class="alert alert-danger py-2" role="alert" v-if="errored">
            {{ error }}
        </div>
        <div class="alert alert-danger mt-3 py-2" role="alert" v-if="messaged">
            {{ message }}
        </div>
        <div class="control-group">
            <label class="label-light">{{
                $t("timetable.createLesson.activity.label")
            }}</label>
            <CustomSelect
                v-model="lesson.action_id"
                :options="activities"
                :placeholder="$t('timetable.createLesson.activity.placeholder')"
                :settings="{ width: '100%' }"
            />
        </div>
        <p
            v-if="v$.action_id.$error"
            class="help-block text-danger text-right"
            style="margin-top: -1rem"
        >
            {{ v$.action_id.$errors[0].$message }}
        </p>
        <div class="control-group">
            <label class="label-light">{{
                $t("timetable.createLesson.dayOfWeek.label")
            }}</label>
            <CustomSelect
                v-model="lesson.day_id"
                :options="days"
                :placeholder="
                    $t('timetable.createLesson.dayOfWeek.placeholder')
                "
                :settings="{ width: '100%' }"
            />
        </div>
        <p
            v-if="v$.day_id.$error"
            class="help-block text-danger text-right"
            style="margin-top: -1rem"
        >
            {{ v$.day_id.$errors[0].$message }}
        </p>
        <Textbox
            v-model="lesson.start_time"
            :type="'time'"
            :required="true"
            :label="$t('timetable.createLesson.startTime.label')"
            :errorMessage="
                v$.start_time.$error
                    ? v$.start_time.$errors[0].$message
                    : validation.start_time
                    ? validation.start_time[0]
                    : ''
            "
        />
        <Textbox
            v-model="lesson.end_time"
            :type="'time'"
            :required="true"
            :label="$t('timetable.createLesson.endTime.label')"
            :errorMessage="
                v$.end_time.$error
                    ? v$.end_time.$errors[0].$message
                    : validation.end_time
                    ? validation.end_time[0]
                    : ''
            "
        />
        <div class="text-right">
            <button
                class="btn btn-primary py-1.5 px-4 mb-4"
                style="border-radius: 10px"
                type="submit"
            >
                {{ $t("spa.buttons.create") }}
            </button>
        </div>
    </form>
</template>

<script>
/* eslint-disable */
import axios from "axios";
//import router from "@/router/router.js";

import { getCookies } from "@/api/request";

import Textbox from "@/components/Elements/TextBox.vue";
import CustomSelect from "@/components/Elements/CustomSelect.vue";

import { useVuelidate } from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import { reactive, computed } from "vue";

export default {
    components: {
        Textbox,
        CustomSelect,
    },
    setup() {
        const lesson = reactive({
            action_id: "",
            group_id: "",
            day_id: "",
            start_time: "",
            end_time: "",
        });

        const rules = computed(() => {
            return {
                action_id: { required },
                day_id: { required },
                start_time: { required },
                end_time: { required },
            };
        });

        const v$ = useVuelidate(rules, lesson);

        return { lesson, v$ };
    },
    data() {
        return {
            activities: [],
            days: [],
            groupId: this.$route.params.groupId,
            errored: false,
            error: "Error",
            validation: {},
        };
    },
    mounted() {
        this.fetchActivities();
        this.fetchDays();
    },
    methods: {
        async fetchActivities() {
            try {
                const response = await axios.get("api/actions", {
                    headers: {
                        "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                    },
                });
                this.activities = response.data.data;
            } catch (error) {
                this.errored = true;
                this.error = this.$t("loading.activities");
                console.error(this.$t("loading.activities"), error);
            } finally {
                this.loading = false;
            }
        },
        async fetchDays() {
            try {
                const response = await axios.get("api/days", {
                    headers: {
                        "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                    },
                });
                this.days = response.data.data;
            } catch (error) {
                this.errored = true;
                this.error = this.$t("loading.days");
                console.error(this.$t("loading.days"), error);
            } finally {
                this.loading = false;
            }
        },
        async createLesson() {
            this.v$.$validate();
            if (!this.v$.$error) {
                try {
                    this.lesson.group_id = this.groupId;

                    const response = await axios.post(
                        "api/lessons",
                        this.lesson,
                        {
                            headers: {
                                "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                            },
                        }
                    );
                    console.log("Lesson created successfully:", response);
                    this.refreshPage();
                } catch (error) {
                    console.error("Error creating lesson:", error);
                    if (error.response.data.error) {
                        this.errored = true;
                        this.error = error.response.data.error;
                    }
                    if (error.response.data.data) {
                        this.validation = error.response.data.data;
                    }
                    if (error.response.data.message) {
                        this.messaged = true;
                        this.message = error.response.data.message;
                    }
                }
            }
        },
        refreshPage() {
            this.$emit("refresh-timetable");
            this.$emit("refresh-lessonCreate");
        },
    },
};
</script>
