<template>
    <div class="container-fluid">
        <div class="container col-lg-6">
            <h2 style="margin-bottom: 0.75rem">
                {{ $t("trustedPersons.title") }}
            </h2>
            <div class="alert alert-danger py-2" role="alert" v-if="errored">
                {{ error }}
            </div>
            <div
                class="alert alert-warning py-2"
                role="alert"
                v-if="trustedPersons.length == 0 && !loading && !errored"
            >
                {{ $t("trustedPersons.dataNo") }}
            </div>
            <div
                v-for="(trustedPerson, index) in trustedPersons"
                :key="index"
                class="row align-items-center d-flex justify-content-center trusted-person-container"
            >
                <div class="col-lg-4">
                    <img
                        class="img-fluid-center side-rounded-fullcircle mt-2 mb-4 mb-lg-2 mt-lg-2"
                        :src="getImageSource(trustedPerson)"
                        alt=""
                    />
                </div>
                <div class="col-lg-8 mt-lg-4">
                    <form @submit.prevent="submitForm" novalidate="novalidate">
                        <div
                            v-for="(control, index) in controls"
                            :key="index"
                            class="control-group"
                        >
                            <label class="label-light">{{
                                $t(control.label)
                            }}</label>
                            <div class="output">
                                <InfoBoxLoader :loading="loading" />
                                <template v-if="!loading">
                                    {{ trustedPerson[control.property] || "-" }}
                                </template>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <InfoLoader :loading="loading" />
        </div>
    </div>
</template>

<script>
import { getCookies } from "@/api/request";

import axios from "axios";
import InfoBoxLoader from "@/components/Elements/InfoBoxLoader.vue";
import InfoLoader from "@/components/Elements/InfoLoader.vue";

import userDefaultImage from "@/assets/img/userDefault-light.png";

export default {
    components: { InfoBoxLoader, InfoLoader },
    data() {
        return {
            trustedPersons: [],
            controls: [
                { label: "trustedPersons.name.label", property: "name" },
                { label: "trustedPersons.email.label", property: "email" },
                { label: "trustedPersons.phone.label", property: "phone" },
            ],
            errored: false,
            error: "Error",
            loading: true,
            familyAccountId: this.$route.params.familyId,
        };
    },
    mounted() {
        this.fetchTrustedPersons();
    },
    methods: {
        async fetchTrustedPersons() {
            try {
                const response = await axios.get(
                    `api/family_accounts/${this.familyAccountId}`,
                    {
                        headers: {
                            "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                        },
                    }
                );
                this.trustedPersons = response.data.data.trusted_persons;
                console.log(response.data.data.trusted_persons);
            } catch (error) {
                this.errored = true;
                this.error = this.$t("trustedPersons.dataLoadingError");
                console.error(
                    this.$t("trustedPersons.dataLoadingError"),
                    error
                );
            } finally {
                this.loading = false;
            }
        },
        getImageSource(trustedPerson) {
            if (this.loading || !trustedPerson.image_data || this.errored) {
                return userDefaultImage;
            } else {
                return `data:image/png;base64,${trustedPerson.image_data}`;
            }
        },
    },
};
</script>
