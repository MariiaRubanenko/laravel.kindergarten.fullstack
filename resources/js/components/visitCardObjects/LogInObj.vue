<template>
    <div class="vertical-center">
        <div class="container-fluid pt-10 mt">
            <div class="container">
                <div class="text-center pb-2">
                    <p class="section-title px-5" style="margin-top: 2rem">
                        <span class="px-2">{{ $t("logIn.title") }}</span>
                    </p>
                    <h1 class="mb-4">{{ $t("logIn.tagline") }}</h1>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-8 mb-5">
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
                        <form @submit.prevent="logIn" novalidate="novalidate">
                            <TextboxThick
                                v-model="user.email"
                                id="email"
                                type="email"
                                :placeholder="$t('logIn.email.placeholder')"
                                :required="true"
                                :errorMessage="
                                    v$.email.$error
                                        ? v$.email.$errors[0].$message
                                        : validation.email
                                        ? validation.email[0]
                                        : ''
                                "
                            />

                            <TextboxThick
                                v-model="user.password"
                                id="password"
                                type="password"
                                :placeholder="$t('logIn.password.placeholder')"
                                :required="true"
                                :errorMessage="
                                    v$.password.$error
                                        ? v$.password.$errors[0].$message
                                        : validation.password
                                        ? validation.password[0]
                                        : ''
                                "
                            />
                            <div class="text-right">
                                <button
                                    class="btn btn-primary py-2 px-4"
                                    style="
                                        border-radius: 10px;
                                        font-size: 1.25rem;
                                        font-weight: 600;
                                    "
                                    type="submit"
                                >
                                    {{ $t("logIn.button") }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TextboxThick from "@/components/Elements/TextBoxThick.vue";
import axios from "axios";
import router from "@/router/router.js";

import { getToken } from "@/api/request";
import { getCookies } from "@/api/request";

import { useVuelidate } from "@vuelidate/core";
import { required, email, minLength, maxLength } from "@vuelidate/validators";
import { reactive, computed } from "vue";

export default {
    components: {
        TextboxThick,
    },
    setup() {
        const user = reactive({
            email: "",
            password: "",
        });

        const rules = computed(() => {
            return {
                email: { required, email },
                password: {
                    required,
                    minLength: minLength(8),
                    maxLength: maxLength(50),
                },
            };
        });

        const v$ = useVuelidate(rules, user);

        return { user, v$ };
    },
    data() {
        return {
            errored: false,
            error: "",
            messaged: false,
            message: "",
            validation: {},
        };
    },
    methods: {
        async logIn() {
            this.v$.$validate();
            if (!this.v$.$error) {
                try {
                    const csrfToken = await getToken();

                    const response = await axios.post("login", this.user, {
                        headers: {
                            "X-XSRF-Token": csrfToken,
                        },
                    });
                    const userAuthenticated = true;
                    localStorage.setItem(
                        "userAuthenticated",
                        userAuthenticated
                    );

                    console.log(response);
                    const userRoleName = response.data.data.roles[0].name;
                    localStorage.setItem("userRole", userRoleName);

                    if (userRoleName === "admin") {
                        this.redirectToGroups();
                    } else if (userRoleName === "teacher") {
                        const userRoleId = response.data.data.staff_id[0];
                        localStorage.setItem("userRoleId", userRoleId);
                        const groupId = await this.fetchStuff(userRoleId);
                        localStorage.setItem("groupId", groupId);
                        this.redirectToGroup(groupId);
                    } else if (userRoleName === "parent") {
                        const userRoleId =
                            response.data.data.family_account_id[0];
                        localStorage.setItem("userRoleId", userRoleId);
                        this.redirectToParent(userRoleId);
                    }
                } catch (error) {
                    console.error("LogIn Error", error);
                    if (error.message) {
                        this.messaged = true;
                        this.message = error.message;
                    }
                    const response = error.response;
                    if (response) {
                        if (response.data) {
                            if (response.data.error) {
                                this.errored = true;
                                this.error = response.data.error;
                            }

                            if (response.data.data) {
                                this.validation = response.data.data;
                            }

                            if (response.data.message) {
                                this.messaged = true;
                                this.message = response.data.message;
                            }
                        }
                    }
                }
            }
        },
        async fetchStuff(staffId) {
            try {
                const response = await axios.get(`api/staffs/${staffId}`, {
                    headers: {
                        "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                    },
                });
                console.log(response);
                return response.data.data.group_id;
            } catch (error) {
                this.errored = true;
                this.error = this.$t("staffs.dataLoadingError");
                console.error(this.$t("staffs.dataLoadingError"), error);
            } finally {
                this.loading = false;
            }
        },
        redirectToGroups() {
            router.push({ path: `/groups` });
        },
        redirectToGroup(groupId) {
            router.push({ path: `/childrenOfGroupProfile/${groupId}` });
        },
        redirectToParent(familyId) {
            router.push({ path: `/payment/${familyId}` });
        },
    },
};
</script>
