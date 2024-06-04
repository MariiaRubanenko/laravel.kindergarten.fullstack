<template>
    <div class="row justify-content-center">
        <div class="col-lg-6 mb-5">
            <h2 style="margin-bottom: 0.75rem">
                {{ $t("groups.createGroup.title") }}
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
            <form @submit.prevent="createGroup" novalidate="novalidate">
                <Textbox
                    v-model="group.name"
                    id="name"
                    :type="'text'"
                    :placeholder="$t('groups.createGroup.placeholder')"
                    :required="true"
                    :label="$t('groups.createGroup.label')"
                    :errorMessage="
                        v$.name.$error
                            ? v$.name.$errors[0].$message
                            : validation.name
                            ? validation.name[0]
                            : ''
                    "
                />
                <div class="text-right" style="margin-top: -0.5rem">
                    <button
                        class="btn btn-primary py-2 px-2.5"
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
import Textbox from "@/components/Elements/TextBox.vue";
import axios from "axios";
import router from "@/router/router.js";

import { getCookies } from "@/api/request";

import { useVuelidate } from "@vuelidate/core";
import { required, minLength, maxLength } from "@vuelidate/validators";
import { reactive, computed } from "vue";

export default {
    components: {
        Textbox,
    },
    setup() {
        const group = reactive({ name: "" });

        const rules = computed(() => {
            return {
                name: {
                    required,
                    minLength: minLength(4),
                    maxLength: maxLength(50),
                },
            };
        });

        const v$ = useVuelidate(rules, group);

        return { group, v$ };
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
        async createGroup() {
            this.v$.$validate();
            if (!this.v$.$error) {
                try {
                    const response = await axios.post(
                        "api/groups",
                        this.group,
                        {
                            headers: {
                                "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                            },
                        }
                    );
                    console.log("Group created successfully:", response.data);
                    router.go();
                } catch (error) {
                    console.error("Error creating group:", error);
                    console.error("Error creating group:", error);
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
