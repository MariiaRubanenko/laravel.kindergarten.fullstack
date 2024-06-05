<template>
    <div class="row justify-content-center">
        <div class="col-lg-6 mb-5">
            <h2 style="margin-bottom: 0.75rem">
                {{ $t("createChild.title") }}
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
            <form @submit.prevent="createChild" novalidate="novalidate">
                <Textbox
                    v-model="child.name"
                    :type="text"
                    :placeholder="$t('createChild.name.placeholder')"
                    :required="true"
                    :label="$t('createChild.name.label')"
                    :errorMessage="
                        v$.name.$error
                            ? v$.name.$errors[0].$message
                            : validation.name
                            ? validation.name[0]
                            : ''
                    "
                />
                <div class="control-group">
                    <label class="label-light">{{
                        $t("createChild.gender.label")
                    }}</label>
                    <div class="button-container">
                        <ChooseButton
                            style="margin-right: 2rem"
                            @click="selectGender('male')"
                            :selected="child.gender === 'male'"
                            >{{ $t("createChild.gender.male") }}</ChooseButton
                        >
                        <ChooseButton
                            @click="selectGender('female')"
                            :selected="child.gender === 'female'"
                            >{{ $t("createChild.gender.female") }}</ChooseButton
                        >
                    </div>
                </div>
                <p
                    v-if="v$.gender.$error"
                    class="help-block text-danger text-right"
                    style="margin-top: -1rem"
                >
                    {{ v$.gender.$errors[0].$message }}
                </p>
                <Textbox
                    v-model="child.birthday"
                    :type="'date'"
                    :placeholder="$t('createChild.birth.placeholder')"
                    :required="true"
                    :label="$t('createChild.birth.label')"
                    :errorMessage="
                        v$.birthday.$error
                            ? v$.birthday.$errors[0].$message
                            : validation.birthday
                            ? validation.birthday[0]
                            : ''
                    "
                />
                <div class="text-right">
                    <button
                        class="btn btn-primary py-2 px-4"
                        style="border-radius: 10px"
                        type="submit"
                    >
                        {{ $t("spa.buttons.add") }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import router from "@/router/router.js";

import { getCookies } from "@/api/request";

import Textbox from "@/components/Elements/TextBox.vue";
import ChooseButton from "@/components/Elements/chooseButton.vue";

import { useVuelidate } from "@vuelidate/core";
import { required, minLength, maxLength } from "@vuelidate/validators";
import { reactive, computed } from "vue";

export default {
    components: {
        Textbox,
        ChooseButton,
    },
    setup() {
        const child = reactive({
            name: "",
            gender: "",
            birthday: "",
            family_account_id: null,
        });

        const rules = computed(() => {
            return {
                name: {
                    required,
                    minLength: minLength(2),
                    maxLength: maxLength(50),
                },
                gender: { required },
                birthday: { required },
            };
        });

        const v$ = useVuelidate(rules, child);

        return { child, v$ };
    },
    data() {
        return {
            familyAccountId: this.$route.params.familyId,
            errored: false,
            error: "Error",
            messaged: false,
            message: "",
            validation: {},
        };
    },
    methods: {
        async createChild() {
            this.v$.$validate();
            if (!this.v$.$error) {
                try {
                    this.child.family_account_id = this.familyAccountId;

                    const response = await axios.post(
                        "api/child_profiles",
                        this.child,
                        {
                            headers: {
                                "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                            },
                        }
                    );
                    console.log("Child created successfully:", response.data);
                    this.redirectToFamily();
                } catch (error) {
                    console.error("Error creating child:", error);
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
        selectGender(gender) {
            this.child.gender = gender;
        },
        redirectToFamily() {
            router.push({
                path: `/familyProfile/${this.child.family_account_id}`,
            });
        },
    },
};
</script>
