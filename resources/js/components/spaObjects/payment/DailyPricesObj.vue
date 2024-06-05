<template>
    <div class="row justify-content-center">
        <div class="col-lg-6 mb-5">
            <h2 style="margin-bottom: 0.75rem">
                {{ $t("dailyPrices.title") }}
            </h2>
            <div class="alert alert-danger py-2" role="alert" v-if="errored">
                {{ error }}
            </div>
            <div
                class="alert alert-warning py-2"
                role="alert"
                v-if="dailyPrices.length == 0 && !loading"
            >
                {{ $t("groupChildren.dataNo") }}
            </div>
            <div
                class="output-group"
                v-for="(dailyPrices, index) in dailyPrices"
                :key="index"
            >
                <label class="label-light">{{
                    $t("months." + dailyPrices.month_id)
                }}</label>
                <div class="output mb-2">
                    {{ dailyPrices.price }}
                </div>
            </div>
            <InfoLoader :loading="loading" />
        </div>
    </div>
</template>

<script>
import axios from "axios";

import { getCookies } from "@/api/request";

import InfoLoader from "@/components/Elements/InfoLoader.vue";

export default {
    components: {
        InfoLoader,
    },
    data() {
        return {
            dailyPrices: [],
            loading: true,
            errored: false,
            error: "Error",
        };
    },
    mounted() {
        this.fetchdailyPrices();
    },
    methods: {
        async fetchdailyPrices() {
            try {
                const response = await axios.get("api/daily_prices", {
                    headers: {
                        "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                    },
                });
                this.dailyPrices = response.data.data;
                console.log(response.data);
            } catch (error) {
                this.errored = true;
                this.error = this.$t("loading.dailyPrices");
                console.error(this.$t("loading.dailyPrices"), error);
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>
