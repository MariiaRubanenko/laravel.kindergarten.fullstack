<template>
    <div>
        <h2 style="margin-bottom: 0.75rem; margin-top: 1rem">
            {{ $t("userProfile.phoneChanging.title") }}
        </h2>
        <form @submit.prevent="changeUserPhone" novalidate="novalidate">
            <Textbox
                v-model="changePhone.newPhone"
                :type="'text'"
                :placeholder="
                    $t('userProfile.phoneChanging.newPhone.placeholder')
                "
                :prefix="'+380'"
                :required="true"
                :label="$t('userProfile.phoneChanging.newPhone.label')"
                :errorMessage="errorMessage"
            />
            <div class="text-right" style="margin-top: -0.5rem">
                <button
                    class="btn btn-primary py-2 px-2.5"
                    style="border-radius: 10px"
                    type="submit"
                >
                    {{ $t("spa.buttons.change") }}
                </button>
            </div>
        </form>
        <div class="alert alert-danger mt-3 py-2" role="alert" v-if="errored">
            {{ error }}
        </div>
        <div class="alert alert-danger mt-3 py-2" role="alert" v-if="messaged">
            {{ message }}
        </div>
    </div>
</template>

<script>
import Textbox from "@/components/Elements/TextBox.vue";
import { useVuelidate } from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import { reactive, computed } from "vue";
import { getCookies } from "@/api/request";
import axios from "axios";
import router from "@/router/router.js";

export default {
    components: { Textbox },
    props: {
        user: {
            type: Object,
            required: true,
        },
        userRole: {
            type: String,
            required: true,
        },
        userRoleId: {
            type: String,
            required: true,
        },
    },
    setup() {
        const changePhone = reactive({
            newPhone: "",
            validation: {},
            errored: false,
            error: "Error",
            messaged: false,
            message: "",
        });

        const rules = computed(() => ({
            newPhone: { required },
        }));

        const v$ = useVuelidate(rules, changePhone);

        return { changePhone, v$ };
    },
    computed: {
        errorMessage() {
            if (this.v$.newPhone.$error) {
                return this.v$.newPhone.$errors[0].$message;
            } else if (this.changePhone.validation.phone_number) {
                return this.changePhone.validation.phone_number[0];
            }
            return "";
        },
    },
    methods: {
        async changeUserPhone() {
            this.v$.$validate();
            if (!this.v$.$error) {
                try {
                    const payload = {
                        user_id: this.user.user_id,
                        phone_number:
                            "+380" +
                            this.changePhone.newPhone.replace(/[^0-9]/g, ""),
                    };

                    if (this.userRole === "teacher") {
                        await axios.put(
                            `api/staffs/${this.userRoleId}`,
                            payload,
                            {
                                headers: {
                                    "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                                },
                            }
                        );
                    } else if (this.userRole === "parent") {
                        await axios.put(
                            `api/family_accounts/${this.userRoleId}`,
                            payload,
                            {
                                headers: {
                                    "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                                },
                            }
                        );
                    }
                    this.$emit("refresh-main");
                } catch (error) {
                    console.error("Error while changing phone:", error);
                    if (error.response.data.error) {
                        this.changePhone.errored = true;
                        this.changePhone.error = error.response.data.error;
                    }
                    if (error.response.data.data) {
                        this.changePhone.validation = error.response.data.data;
                    }
                    if (error.response.data.message) {
                        this.changePhone.messaged = true;
                        this.changePhone.message = error.response.data.message;
                    }
                }
            }
        },
    },
};
</script>
