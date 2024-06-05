<template>
    <div class="row justify-content-center">
        <div class="col-lg-6 mb-5">
            <form @submit.prevent="createDailyPrices" novalidate="novalidate">
                <h2 style="margin-bottom: 0.75rem">
                    {{ $t("createDailyPrices.title") }}
                </h2>
                <div
                    class="alert alert-danger mt-3 py-2"
                    role="alert"
                    v-if="errored"
                >
                    {{ error }}
                </div>
                <div
                    class="alert alert-danger mt-3 py-2"
                    role="alert"
                    v-if="messaged"
                >
                    {{ message }}
                </div>
                <Textbox
                    v-model="dailyPrices.price"
                    :type="'text'"
                    :placeholder="$t('createDailyPrices.price.placeholder')"
                    :required="true"
                    :label="$t('createDailyPrices.price.label')"
                    :errorMessage="
                        v$.price.$error
                            ? v$.price.$errors[0].$message
                            : validation.price
                            ? validation.price[0]
                            : ''
                    "
                />
                <div class="control-group">
                    <label class="label-light">{{
                        $t("createDailyPrices.month.label")
                    }}</label>
                    <CustomSelect
                        v-model="dailyPrices.month_id"
                        :options="months"
                        :placeholder="$t('createDailyPrices.month.placeholder')"
                        :settings="{ width: '100%' }"
                    />
                </div>
                <p
                    v-if="v$.month_id.$error"
                    class="help-block text-danger text-right"
                    style="margin-top: -1rem"
                >
                    {{ v$.month_id.$errors[0].$message }}
                </p>
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
import CustomSelect from "@/components/Elements/CustomSelect.vue";

import axios from "axios";
import router from "@/router/router.js";

import { getCookies } from "@/api/request";

import { useVuelidate } from "@vuelidate/core";
import { required, decimal } from "@vuelidate/validators";
import { reactive, computed } from "vue";

export default {
    components: {
        Textbox,
        CustomSelect,
    },
    setup() {
        const dailyPrices = reactive({ price: "", month_id: "" });

        const rules = computed(() => {
            return {
                price: {
                    required,
                    decimal,
                },
                month_id: {
                    required,
                },
            };
        });

        const v$ = useVuelidate(rules, dailyPrices);

        return { dailyPrices, v$ };
    },
    data() {
        return {
            months: {},
            errored: false,
            error: "Error",
            messaged: false,
            message: "",
            validation: {},
        };
    },
    mounted() {
        this.fetchMonths();
    },
    methods: {
        async fetchMonths() {
            try {
                const response = await axios.get("api/months", {
                    headers: {
                        "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                    },
                });
                this.months = response.data.data;
            } catch (error) {
                this.errored = true;
                this.error = this.$t("loading.months");
                console.error(this.$t("loading.months"), error);
            } finally {
                this.loading = false;
            }
        },
        async createDailyPrices() {
            this.v$.$validate();
            if (!this.v$.$error) {
                try {
                    const response = await axios.post(
                        "api/daily_prices",
                        this.dailyPrices,
                        {
                            headers: {
                                "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                            },
                        }
                    );
                    console.log(
                        "Daily price created successfully:",
                        response.data
                    );
                    router.go();
                } catch (error) {
                    console.error("Error creating daily price:", error);
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
