<template>
    <div class="row justify-content-center">
        <div class="col-lg-6 mb-5">
            <h2 v-if="userRole === 'admin'" style="margin-bottom: 1.5rem">
                {{ $t("payments.title") }}
            </h2>
            <h2 v-if="userRole === 'parent'" style="margin-bottom: 1.5rem">
                {{ $t("payments.titleParent") }}
            </h2>
            <div class="alert alert-danger py-2" role="alert" v-if="errored">
                {{ error }}
            </div>
            <div
                class="alert alert-warning py-2"
                role="alert"
                v-if="payments.length == 0 && !loading"
            >
                {{ $t("payments.dataNo") }}
            </div>
            <div
                class="control-group-payment"
                v-for="(payment, index) in payments"
                :key="index"
            >
                <label
                    v-if="payment.monthly_payment != 0"
                    class="label-light"
                    >{{ $t("months." + payment.month_id) }}</label
                >

                <div v-if="payment.monthly_payment != 0" class="output-group">
                    <div class="output mb-2">
                        {{ payment.monthly_payment }}
                    </div>

                    <button
                        v-if="
                            payment.payment_status === 'unpaid' &&
                            userRole === 'parent'
                        "
                        class="btn btn-danger mb-2 ml-2 px-2.5"
                        style="border-radius: 5px; width: 6rem"
                        type="button"
                        @click="this.redirectToBill(payment.id_payment)"
                    >
                        {{ $t("payments.buttons.pay") }}
                    </button>
                    <button
                        v-if="
                            payment.payment_status === 'paid' &&
                            userRole === 'parent'
                        "
                        class="btn btn-secondary mb-2 ml-2 px-2.5"
                        style="border-radius: 5px; width: 6rem"
                        type="button"
                        @click="this.redirectToBill(payment.id_payment)"
                    >
                        {{ $t("payments.buttons.bill") }}
                    </button>

                    <button
                        v-if="
                            payment.payment_status === 'unpaid' &&
                            userRole === 'admin'
                        "
                        class="btn btn-danger mb-2 ml-2 px-2.5"
                        style="border-radius: 5px; width: 8rem"
                        type="button"
                        @click="this.redirectToBill(payment.id_payment)"
                    >
                        {{ $t("payments.buttons.unpaid") }}
                    </button>

                    <button
                        v-if="
                            payment.payment_status === 'paid' &&
                            userRole === 'admin'
                        "
                        class="btn btn-secondary mb-2 ml-2 px-2.5"
                        style="border-radius: 5px; width: 8rem"
                        type="button"
                        @click="this.redirectToBill(payment.id_payment)"
                    >
                        {{ $t("payments.buttons.paid") }}
                    </button>
                </div>
            </div>
            <InfoLoader :loading="loading" />
        </div>
    </div>
</template>

<script>
import axios from "axios";
import router from "@/router/router.js";

import { getCookies } from "@/api/request";

import InfoLoader from "@/components/Elements/InfoLoader.vue";

export default {
    components: {
        InfoLoader,
    },
    data() {
        return {
            payments: [],
            familyId: this.$route.params.familyId,
            userRole: localStorage.getItem("userRole"),
            loading: true,
            errored: false,
            error: "Error",
        };
    },
    mounted() {
        this.fetchPayments();
    },
    methods: {
        async fetchPayments() {
            try {
                const response = await axios.get(
                    `api/family_account_payments/${this.familyId}`,
                    {
                        headers: {
                            "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                        },
                    }
                );
                this.payments = response.data.data;
                console.log(response.data);
            } catch (error) {
                this.errored = true;
                this.error = this.$t("loading.payments");
                console.error(this.$t("loading.payments"), error);
            } finally {
                this.loading = false;
            }
        },
        redirectToBill(billId) {
            router.push({ path: `/bill/${billId}` });
        },
    },
};
</script>
