<template>
    <div class="row justify-content-center">
        <div class="col-lg-7 mb-5">
            <h2 style="margin-bottom: 1rem">
                {{ $t("communication.title") }}
            </h2>
            <div
                class="alert alert-danger mb-3 py-2"
                role="alert"
                v-if="errored"
            >
                {{ error }}
            </div>
            <div
                class="alert alert-danger mb-3 py-2"
                role="alert"
                v-if="messaged"
            >
                {{ message }}
            </div>
            <form @submit.prevent="sendEmail" novalidate="novalidate">
                <div class="control-group">
                    <label class="label-light">{{
                        $t("communication.email.label")
                    }}</label>
                    <CustomSelect
                        v-model="mail.email"
                        :options="parents"
                        :placeholder="$t('communication.email.placeholder')"
                        :settings="{ width: '100%' }"
                    />
                </div>
                <p
                    v-if="v$.email.$error"
                    class="help-block text-danger text-right"
                    style="margin-top: -1rem"
                >
                    {{ v$.email.$errors[0].$message }}
                </p>
                <TextArea
                    v-model="mail.text_email"
                    :placeholder="$t('communication.mail.placeholder')"
                    :required="true"
                    :rows="20"
                    :errorMessage="
                        v$.text_email.$error
                            ? v$.text_email.$errors[0].$message
                            : validation.text_email
                            ? validation.text_email[0]
                            : ''
                    "
                />
                <div class="text-right" style="margin-top: -0.5rem">
                    <button
                        class="btn btn-primary py-2 px-2.5"
                        style="border-radius: 10px; width: 7rem"
                        type="submit"
                    >
                        {{ $t("spa.buttons.send") }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import TextArea from "@/components/Elements/TextArea.vue";
import CustomSelect from "@/components/Elements/CustomSelect.vue";

import { useVuelidate } from "@vuelidate/core";
import { required, maxLength } from "@vuelidate/validators";
import { reactive, computed } from "vue";

import { getCookies } from "@/api/request";
import axios from "axios";
import router from "@/router/router.js";

import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import { ref } from "vue";

export default {
    components: {
        CustomSelect,
        TextArea,
    },
    setup() {
        const mail = reactive({ email: "", text_email: "" });

        const updating = ref(false);

        const rules = computed(() => {
            return {
                email: { required },
                text_email: {
                    required,
                    maxLength: maxLength(2000),
                },
            };
        });

        const v$ = useVuelidate(rules, mail);

        return { mail, v$, updating };
    },
    data() {
        return {
            parents: {},
            errored: false,
            error: "Error",
            messaged: false,
            message: "",
            validation: {},
            groupId: localStorage.getItem("groupId"),
            userRole: localStorage.getItem("userRole"),
        };
    },
    mounted() {
        if (this.userRole == "teacher") {
            this.fetchParentOfTeacherGroup();
        }
        if (this.userRole == "admin") {
            this.fetchAllParents();
        }
    },
    methods: {
        async fetchParentOfTeacherGroup() {
            try {
                const response = await axios.get(
                    `api/family_accountsByGroup/${this.groupId}`,
                    {
                        headers: {
                            "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                        },
                    }
                );
                this.parents = response.data.map((parent) => ({
                    id: parent.email,
                    text: `${parent.name} - ${parent.email}`,
                }));
            } catch (error) {
                this.errored = true;
                this.error = this.$t("families.dataLoadingError");
                console.error(this.$t("families.dataLoadingError"), error);
            } finally {
                this.loading = false;
            }
        },
        async fetchAllParents() {
            try {
                const response = await axios.get("api/family_accounts", {
                    headers: {
                        "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                    },
                });
                this.parents = response.data.data.map((parent) => ({
                    id: parent.email,
                    text: `${parent.name} - ${parent.email}`,
                }));
                console.log(response.data.data);
            } catch (error) {
                this.errored = true;
                this.error = this.$t("families.dataLoadingError");
                console.error(this.$t("families.dataLoadingError"), error);
            } finally {
                this.loading = false;
            }
        },
        async sendEmail() {
            this.v$.$validate();
            if (!this.v$.$error) {
                try {
                    const response = await axios.post(
                        "api/send_email",
                        this.mail,
                        {
                            headers: {
                                "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                            },
                        }
                    );
                    console.log("Email sent successfully:", response.data);
                    toast.success(response.data.message, { autoClose: 6000 });
                    this.updating = true; // Устанавливаем флаг обновления
                    // Очищаем поля паролей
                    this.mail.email = "";
                    this.mail.text_email = "";
                    setTimeout(() => {
                        this.updating = true;
                        router.go();
                    }, 6000);
                } catch (error) {
                    console.error("Error sending email:", error);
                    console.error("Error sending email:", error);
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
    },
};
</script>
