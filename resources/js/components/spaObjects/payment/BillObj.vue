<template>
    <div class="row justify-content-center">
        <div class="col-lg-5 mb-5">
            <h2 style="margin-bottom: 0.75rem">
                {{ $t("bill.title") }}
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
            <div class="p-3 trusted-person-container">
                <div
                    v-for="(control, index) in controls"
                    :key="index"
                    class="control-group"
                >
                    <label class="label-light" style="min-width: 150px">{{
                        $t(control.label)
                    }}</label>
                    <div class="output">
                        <InfoBoxLoader :loading="loading" />
                        <template v-if="!loading">
                            {{ bill[control.property] || "-" }}
                        </template>
                    </div>
                </div>
                <div>
                    <button
                        v-if="
                            bill.payment_status === 'unpaid' &&
                            userRole === 'parent'
                        "
                        class="btn btn-danger py-2"
                        style="border-radius: 10px; width: 100%"
                        @click="payBill()"
                    >
                        {{ $t("payments.buttons.pay") }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
//import router from "@/router/router.js";

import { getCookies } from "@/api/request";

import InfoBoxLoader from "@/components/Elements/InfoBoxLoader.vue";

export default {
    components: {
        InfoBoxLoader,
    },
    data() {
        return {
            bill: {},
            controls: [
                { label: "bill.name.label", property: "user_name" },
                { label: "bill.month.label", property: "month" },
                { label: "bill.dailyPrice.label", property: "daily_price" },
                { label: "bill.price.label", property: "monthly_payment" },
                { label: "bill.date.label", property: "payment_date" },
            ],
            billId: this.$route.params.billId,
            userRole: localStorage.getItem("userRole"),
            userRoleId: localStorage.getItem("userRoleId"),
            loading: true,
            errored: false,
            error: "Error",
            messaged: false,
            message: "",
        };
    },
    mounted() {
        this.fetchPayment();
    },
    methods: {
        async fetchPayment() {
            try {
                const response = await axios.get(
                    `api/payments/${this.billId}`,
                    {
                        headers: {
                            "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                        },
                    }
                );
                this.bill = response.data.data;
                console.log(response.data);
            } catch (error) {
                this.errored = true;
                this.error = this.$t("loading.bill");
                console.error(this.$t("loading.bill"), error);
            } finally {
                this.loading = false;
            }
        },
        async payBill() {
            try {
                axios
                    .post(
                        "/session",
                        {
                            id_payment: this.bill.id_payment,
                            monthly_payment: this.bill.monthly_payment,
                        },
                        {
                            headers: {
                                "Content-Type": "application/json",
                                "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                            },
                        }
                    )
                    .then((response) => {
                        const paymentUrl = response.data.url;
                        window.location.href = paymentUrl;
                        console.log(response);
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            } catch (error) {
                console.error("Error while paying the bill", error);
                if (error.response.data.error) {
                    this.errored = true;
                    this.error = error.response.data.error;
                }
                if (error.response.data.message) {
                    this.messaged = true;
                    this.message = error.response.data.message;
                }
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>
