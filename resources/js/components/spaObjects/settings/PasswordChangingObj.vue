<template>
    <div class="row justify-content-center">
        <div class="col-lg-6 mb-5">
            <form @submit.prevent="passwordChanging" novalidate="novalidate">
                <h2 style="margin-bottom: 0.75rem">
                    {{ $t("settings.passwordChanging.title") }}
                </h2>
                <div
                    class="alert alert-danger py-2 mb-3"
                    role="alert"
                    v-if="messaged"
                >
                    {{ message }}
                </div>
                <div
                    class="alert alert-danger py-2 mb-3"
                    role="alert"
                    v-if="errored"
                >
                    {{ error }}
                </div>
                <Textbox
                    v-model="passwords.passwordOld"
                    :type="'password'"
                    :placeholder="
                        $t('settings.passwordChanging.passwordOld.placeholder')
                    "
                    :label="$t('settings.passwordChanging.passwordOld.label')"
                    :required="true"
                    :errorMessage="
                        v$.passwordOld.$error
                            ? v$.passwordOld.$errors[0].$message
                            : validation.passwordOld
                            ? validation.passwordOld[0]
                            : ''
                    "
                />
                <Textbox
                    v-model="passwords.passwordNew"
                    :type="'password'"
                    :placeholder="
                        $t('settings.passwordChanging.passwordNew.placeholder')
                    "
                    :label="$t('settings.passwordChanging.passwordNew.label')"
                    :required="true"
                    :errorMessage="
                        v$.passwordNew.$error
                            ? v$.passwordNew.$errors[0].$message
                            : validation.passwordNew
                            ? validation.passwordNew[0]
                            : ''
                    "
                />
                <Textbox
                    v-model="passwords.passwordConfirm"
                    :type="'password'"
                    :placeholder="
                        $t(
                            'settings.passwordChanging.passwordConfirm.placeholder'
                        )
                    "
                    :label="
                        $t('settings.passwordChanging.passwordConfirm.label')
                    "
                    :required="true"
                    :errorMessage="
                        v$.passwordConfirm.$error
                            ? v$.passwordConfirm.$errors[0].$message
                            : validation.passwordConfirm
                            ? validation.passwordConfirm[0]
                            : ''
                    "
                />
                <div class="text-right" style="margin-top: -0.5rem">
                    <button
                        class="btn btn-primary py-2 px-4"
                        style="
                            border-radius: 10px;
                            font-size: 1.25rem;
                            font-weight: 600;
                        "
                        type="submit"
                    >
                        {{ $t("spa.buttons.change") }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Textbox from "@/components/Elements/TextBoxThick.vue";
import axios from "axios";
import router from "@/router/router.js";

import { getCookies } from "@/api/request";

import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import { ref } from "vue";

import { useVuelidate } from "@vuelidate/core";
import { required, minLength, maxLength } from "@vuelidate/validators";
import { reactive, computed } from "vue";

export default {
    components: {
        Textbox,
    },
    setup() {
        const passwords = reactive({
            passwordOld: "",
            passwordNew: "",
            passwordConfirm: "",
        });

        const updating = ref(false);

        const rules = computed(() => {
            return {
                passwordOld: {
                    required,
                    minLength: minLength(8),
                    maxLength: maxLength(100),
                },
                passwordNew: {
                    required,
                    minLength: minLength(8),
                    maxLength: maxLength(100),
                },
                passwordConfirm: {
                    required,
                    minLength: minLength(8),
                    maxLength: maxLength(100),
                },
            };
        });

        const v$ = useVuelidate(rules, passwords);

        return { passwords, v$, updating };
    },
    data() {
        return {
            errored: false,
            error: "Error",
            messaged: false,
            message: "",
            validation: {},
        };
    },
    methods: {
        async passwordChanging() {
            this.v$.$validate();
            if (!this.v$.$error) {
                try {
                    const csrfToken = getCookies("XSRF-TOKEN");
                    const response = await axios.post(
                        "api/change_password",
                        {
                            old_password: this.passwords.passwordOld,
                            new_password: this.passwords.passwordNew,
                            new_password_confirmation:
                                this.passwords.passwordConfirm,
                        },
                        {
                            headers: {
                                "X-XSRF-Token": csrfToken,
                            },
                        }
                    );
                    console.log(
                        "Password changed successfully:",
                        response.data
                    );
                    toast.success(response.data.message, { autoClose: 6000 });
                    this.updating = true; // Устанавливаем флаг обновления
                    // Очищаем поля паролей
                    this.passwords.passwordOld = "";
                    this.passwords.passwordNew = "";
                    this.passwords.passwordConfirm = "";
                    setTimeout(() => {
                        this.updating = true;
                        router.go();
                    }, 6000);
                } catch (error) {
                    console.error("Error changing password:", error);
                    if (error.response.data.error) {
                        this.errored = true;
                        this.error = error.response.data.error;
                    }
                    if (error.response.data.errors) {
                        this.validation = error.response.data.errors;
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
