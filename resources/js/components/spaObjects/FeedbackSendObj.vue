<template>
    <div class="row justify-content-center">
        <div class="col-lg-7 mb-5">
            <h2 style="margin-bottom: 1.5rem">
                {{ $t("feedbackSend.title") }}
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
            <form @submit.prevent="createComment" novalidate="novalidate">
                <TextArea
                    v-model="comment.text"
                    :placeholder="$t('feedbackSend.comment.placeholder')"
                    :required="true"
                    :rows="8"
                    :errorMessage="
                        v$.text.$error
                            ? v$.text.$errors[0].$message
                            : validation.text
                            ? validation.text[0]
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
import axios from "axios";
import router from "@/router/router.js";

import TextArea from "@/components/Elements/TextArea.vue";

import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import { ref } from "vue";

import { getCookies } from "@/api/request";
import { useVuelidate } from "@vuelidate/core";
import { required, minLength, maxLength } from "@vuelidate/validators";
import { reactive, computed } from "vue";

export default {
    components: {
        TextArea,
    },
    setup() {
        const comment = reactive({ text: "" });

        const updating = ref(false);

        const rules = computed(() => {
            return {
                text: {
                    required,
                    minLength: minLength(4),
                    maxLength: maxLength(900),
                },
            };
        });

        const v$ = useVuelidate(rules, comment);

        return { comment, v$, updating };
    },
    data() {
        return {
            errored: false,
            error: "Error",
            messaged: false,
            message: "",
            validation: {},
            familyId: this.$route.params.familyId,
            userRole: localStorage.getItem("userRole"),
        };
    },
    methods: {
        async createComment() {
            this.v$.$validate();
            if (!this.v$.$error) {
                try {
                    const commentForSending = {
                        family_account_id: this.familyId,
                        text: this.comment.text,
                    };
                    const response = await axios.post(
                        "api/comment",
                        commentForSending,
                        {
                            headers: {
                                "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                            },
                        }
                    );
                    console.log("Comment sent successfully:", response.data);
                    toast.success(response.data.message, { autoClose: 6000 });
                    this.updating = true;
                    this.comment.text = "";
                    setTimeout(() => {
                        this.updating = false;
                        router.go();
                    }, 6000);
                } catch (error) {
                    console.error("Error sending comment:", error);
                    console.error("Error sending comment:", error);
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
