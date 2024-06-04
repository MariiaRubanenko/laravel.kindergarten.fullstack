<template>
    <form @submit.prevent="createActivity" novalidate="novalidate">
        <h2 style="margin-bottom: 0.75rem">
            {{ $t("timetable.createActivity.title") }}
        </h2>
        <div class="alert alert-danger py-2" role="alert" v-if="errored">
            {{ error }}
        </div>
        <div class="alert alert-danger mt-3 py-2" role="alert" v-if="messaged">
            {{ message }}
        </div>
        <Textbox
            v-model="activity.name"
            id="name"
            :type="text"
            :placeholder="$t('timetable.createActivity.placeholder')"
            :required="true"
            :errorMessage="
                v$.name.$error
                    ? v$.name.$errors[0].$message
                    : validation.name
                    ? validation.name[0]
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
import Textbox from "@/components/Elements/TextBox.vue";
import axios from "axios";

import { getCookies } from "@/api/request";

import { useVuelidate } from "@vuelidate/core";
import { required, minLength, maxLength } from "@vuelidate/validators";
import { reactive, computed } from "vue";

export default {
    components: {
        Textbox,
    },
    setup() {
        const activity = reactive({ name: "" });

        const rules = computed(() => {
            return {
                name: {
                    required,
                    minLength: minLength(4),
                    maxLength: maxLength(50),
                },
            };
        });

        const v$ = useVuelidate(rules, activity);

        return { activity, v$ };
    },
    data() {
        return {
            errored: false,
            error: "Error",
            validation: {},
        };
    },
    methods: {
        async createActivity() {
            this.v$.$validate();
            if (!this.v$.$error) {
                try {
                    const response = await axios.post(
                        "api/actions",
                        this.activity,
                        {
                            headers: {
                                "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                            },
                        }
                    );
                    console.log(
                        "Activity created successfully:",
                        response.data
                    );
                    this.refreshPage();
                } catch (error) {
                    console.error("Error creating activity:", error);
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
            this.$emit("refresh-activityCreate");
            this.$emit("refresh-activityDelete");
            this.$emit("refresh-lessonCreate");
            this.$emit("refresh-timetable");
        },
    },
};
</script>
