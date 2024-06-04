<template>
    <form @submit.prevent="showCustomConfirmation" novalidate="novalidate">
        <h2 style="margin-bottom: 0.75rem">
            {{ $t("timetable.deleteActivity.title") }}
        </h2>
        <div class="alert alert-danger py-2" role="alert" v-if="errored">
            {{ error }}
        </div>
        <div class="alert alert-danger mt-3 py-2" role="alert" v-if="messaged">
            {{ message }}
        </div>
        <CustomSelect
            v-model="activity.activityToDeleteId"
            :options="activities"
            :placeholder="$t('timetable.deleteActivity.placeholder')"
            :settings="{ width: '100%' }"
        />
        <p
            v-if="v$.activityToDeleteId.$error"
            class="help-block text-danger text-right"
            style="margin-bottom: -0.25rem"
        >
            {{ v$.activityToDeleteId.$errors[0].$message }}
        </p>
        <div class="text-right">
            <button
                class="btn btn-danger py-1.5 px-4 mt-3 mb-4"
                style="border-radius: 10px"
                type="submit"
            >
                {{ $t("spa.buttons.delete") }}
            </button>
        </div>
        <ConfirmationMenu
            :showModal="showModal"
            :message="$t('timetable.deleteActivity.deleteMessage')"
            :buttonConfirm="$t('spa.buttons.delete')"
            :buttonCancel="$t('spa.buttons.cancel')"
            @confirm="deleteActivityConfirm"
            @cancel="cancelDelete"
        />
    </form>
</template>

<script>
import CustomSelect from "@/components/Elements/CustomSelect.vue";
import ConfirmationMenu from "@/components/Elements/ConfirmationMenu.vue";

import { getCookies } from "@/api/request";

import { useVuelidate } from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import { reactive, computed } from "vue";

import axios from "axios";

export default {
    components: { CustomSelect, ConfirmationMenu },
    setup() {
        const activity = reactive({ activityToDeleteId: "" });

        const rules = computed(() => {
            return {
                activityToDeleteId: {
                    required,
                },
            };
        });

        const v$ = useVuelidate(rules, activity);

        return { activity, v$ };
    },
    data() {
        return {
            activities: [],
            showModal: false,
            errored: false,
            error: "Error",
        };
    },
    mounted() {
        this.fetchActivities();
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
        async deleteActivity() {
            try {
                await axios.delete(
                    `api/actions/${this.activity.activityToDeleteId}`,
                    {
                        headers: {
                            "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                        },
                    }
                );
                this.closeModal();
                this.refreshPage();
            } catch (error) {
                console.error("Error deleting activity", error);
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
        },
        showCustomConfirmation() {
            this.v$.$validate();
            if (!this.v$.$error) {
                this.showModal = true;
            }
        },
        deleteActivityConfirm() {
            this.deleteActivity();
            this.closeModal();
        },
        cancelDelete() {
            this.activityToDelete = null;
            this.showModal = false;
        },
        closeModal() {
            this.showModal = false;
        },
        refreshPage() {
            this.$emit("refresh-activityDelete");
            this.$emit("refresh-lessonCreate");
            this.$emit("refresh-timetable");
        },
    },
};
</script>
