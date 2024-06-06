<template>
    <div class="row justify-content-center">
        <div class="col-lg-6 mb-5">
            <h2 style="margin-bottom: 0.75rem">
                {{ $t("attendance.title") }}
            </h2>
            <form @submit.prevent="fetchAbsentChildren" novalidate="novalidate">
                <Textbox
                    v-model="attendance.date"
                    id="date"
                    :type="'date'"
                    :required="true"
                    :label="$t(`attendance.date.label`)"
                    :errorMessage="
                        v$.date.$error
                            ? v$.date.$errors[0].$message
                            : validation.date
                            ? validation.date[0]
                            : ''
                    "
                />
                <div
                    class="text-right"
                    style="margin-top: -0.5rem; margin-bottom: 2rem"
                >
                    <button
                        class="btn btn-primary py-2 px-2.5"
                        style="border-radius: 10px"
                        type="submit"
                    >
                        {{ $t("spa.buttons.find") }}
                    </button>
                </div>
            </form>
            <div
                class="alert alert-danger py-2"
                role="alert"
                v-if="errored && !loading"
            >
                {{ error }}
            </div>
            <div
                class="alert alert-warning py-2"
                role="alert"
                v-if="absentChildren == 0 && !loading"
            >
                {{ $t("attendance.dataNo") }}
            </div>
            <div
                class="trusted-person-container pt-4 pr-3 pl-3"
                v-for="(absentChild, index) in absentChildren"
                :key="index"
                @click="redirectToChild(absentChild.chld_id)"
            >
                <div
                    v-for="(control, index) in controls"
                    :key="index"
                    class="control-group"
                >
                    <label class="label-light">{{ $t(control.label) }}</label>
                    <div class="output">
                        <InfoBoxLoader :loading="loading" />
                        <template v-if="!loading">
                            {{ absentChild[control.property] || "-" }}
                        </template>
                    </div>
                </div>
            </div>
            <InfoLoader :loading="loading" />
        </div>
    </div>
</template>

<script>
import axios from "axios";
import router from "@/router/router.js";

import { getCookies } from "@/api/request";

import InfoLoader from "@/components/Elements/InfoLoader.vue";
import Textbox from "@/components/Elements/TextBox.vue";

import { useVuelidate } from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import { reactive, computed } from "vue";

export default {
    components: {
        InfoLoader,
        Textbox,
    },
    setup() {
        const getCurrentDate = () => {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, "0");
            const day = String(today.getDate()).padStart(2, "0");
            return `${year}-${month}-${day}`;
        };

        const attendance = reactive({ date: getCurrentDate() });

        const rules = computed(() => {
            return {
                date: {
                    required,
                },
            };
        });

        const v$ = useVuelidate(rules, attendance);

        return { attendance, v$ };
    },
    data() {
        return {
            absentChildren: [],
            controls: [
                { label: "attendance.name.label", property: "name" },
                { label: "attendance.reason.label", property: "reason" },
            ],
            loading: true,
            errored: false,
            error: "Error",
            validation: {},
            groupId: this.$route.params.groupId,
        };
    },
    mounted() {
        this.fetchAbsentChildren();
    },
    methods: {
        async fetchAbsentChildren() {
            this.v$.$validate();
            if (!this.v$.$error) {
                try {
                    const response = await axios.get(
                        `api/absent_сhildren/${this.groupId}/date/${this.attendance.date}`,
                        {
                            headers: {
                                "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                            },
                        }
                    );
                    this.absentChildren = response.data;
                    console.log(response.data);
                } catch (error) {
                    console.error(
                        this.$t("attendance.dataLoadingError"),
                        error
                    );
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
                } finally {
                    this.loading = false;
                }
            }
        },
        redirectToChild(childId) {
            router.push({ path: `/childProfile/${childId}` });
        },
    },
};
</script>
