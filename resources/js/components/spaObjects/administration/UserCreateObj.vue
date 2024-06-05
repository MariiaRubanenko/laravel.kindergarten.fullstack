<template>
    <div class="row justify-content-center">
        <div class="col-lg-6 mb-5">
            <h2 style="margin-bottom: 0.75rem">
                {{ $t("createUser.title") }}
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
            <form @submit.prevent="createUser" novalidate="novalidate">
                <Textbox
                    v-model="user.name"
                    :type="text"
                    :placeholder="$t('createUser.name.placeholder')"
                    :required="true"
                    :label="$t('createUser.name.label')"
                    :errorMessage="
                        v$.name.$error
                            ? v$.name.$errors[0].$message
                            : validation.name
                            ? validation.name[0]
                            : ''
                    "
                />
                <Textbox
                    v-model="user.email"
                    :type="'email'"
                    :placeholder="$t('createUser.email.placeholder')"
                    :required="true"
                    :label="$t('createUser.email.label')"
                    :errorMessage="
                        v$.email.$error
                            ? v$.email.$errors[0].$message
                            : validation.email
                            ? validation.email[0]
                            : ''
                    "
                />
                <Textbox
                    v-model="user.password"
                    :type="'password'"
                    :placeholder="$t('createUser.password.placeholder')"
                    :required="true"
                    :label="$t('createUser.password.label')"
                    :errorMessage="
                        v$.password.$error
                            ? v$.password.$errors[0].$message
                            : validation.password
                            ? validation.password[0]
                            : ''
                    "
                />
                <div class="control-group">
                    <label class="label-light">{{
                        $t("createUser.role.label")
                    }}</label>
                    <div class="button-container">
                        <ChooseButton
                            style="margin-right: 1rem"
                            @click="selectRole('teacher')"
                            :selected="user.role === 'teacher'"
                            >{{ $t("createUser.role.teacher") }}</ChooseButton
                        >
                        <ChooseButton
                            style="margin-right: 1rem"
                            @click="selectRole('parent')"
                            :selected="user.role === 'parent'"
                            >{{ $t("createUser.role.parent") }}</ChooseButton
                        >
                        <ChooseButton
                            @click="selectRole('admin')"
                            :selected="user.role === 'admin'"
                            >{{ $t("createUser.role.admin") }}</ChooseButton
                        >
                    </div>
                </div>
                <p
                    v-if="v$.role.$error"
                    class="help-block text-danger text-right"
                    style="margin-top: -1rem"
                >
                    {{ v$.role.$errors[0].$message }}
                </p>
                <div class="text-right">
                    <button
                        class="btn btn-primary py-2 px-4"
                        style="border-radius: 10px"
                        type="submit"
                    >
                        {{ $t("spa.buttons.create") }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { getCookies } from "@/api/request";

import axios from "axios";
import router from "@/router/router.js";

import Textbox from "@/components/Elements/TextBox.vue";
import ChooseButton from "@/components/Elements/chooseButton.vue";

import { useVuelidate } from "@vuelidate/core";
import { required, email, minLength, maxLength } from "@vuelidate/validators";
import { reactive, computed } from "vue";

export default {
    components: {
        Textbox,
        ChooseButton,
    },
    setup() {
        const user = reactive({
            name: "",
            email: "",
            password: "",
            role: "",
        });

        const rules = computed(() => {
            return {
                name: {
                    required,
                    minLength: minLength(2),
                    maxLength: maxLength(50),
                },
                email: { required, email },
                password: {
                    required,
                    minLength: minLength(8),
                    maxLength: maxLength(50),
                },
                role: { required },
            };
        });

        const v$ = useVuelidate(rules, user);

        return { user, v$ };
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
        async createUser() {
            this.v$.$validate();
            if (!this.v$.$error) {
                try {
                    const response = await axios.post(
                        "api/register",
                        this.user,
                        {
                            headers: {
                                "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                            },
                        }
                    );
                    console.log("User created successfully:", response.data);
                    this.redirectToUser();
                } catch (error) {
                    console.error("Error creating user:", error);
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
        selectRole(role) {
            this.user.role = role;
        },
        redirectToUser() {
            if (this.user.role === "teacher") {
                router.push({ path: `/staff` });
            } else if (this.user.role === "parent") {
                router.push({ path: `/families` });
            }
        },
    },
};
</script>
