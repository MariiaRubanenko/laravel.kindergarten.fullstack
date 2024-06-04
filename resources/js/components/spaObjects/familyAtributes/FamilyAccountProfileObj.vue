<template>
    <div class="container-fluid">
        <div class="container col-lg-6 mb-5">
            <h2 style="margin-bottom: 0.75rem">
                {{ $t("parentProfile.title") }}
            </h2>
            <div class="alert alert-danger py-2" role="alert" v-if="errored">
                {{ error }}
            </div>
            <div
                class="row align-items-center d-flex justify-content-center trusted-person-container"
            >
                <div class="col-lg-4">
                    <img
                        class="img-fluid-center side-rounded-fullcircle mt-2 mb-4 mb-lg-2 mt-lg-2"
                        :src="getImageSource()"
                        alt=""
                    />
                </div>
                <div class="col-lg-8 mt-lg-4">
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
                                {{ parent[control.property] || "-" }}
                            </template>
                        </div>
                    </div>
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

import userDefaultImage from "@/assets/img/userDefault-light.png";

export default {
    components: { InfoBoxLoader },
    data() {
        return {
            parent: {},
            controls: [
                { label: "parentProfile.name.label", property: "name" },
                { label: "parentProfile.email.label", property: "email" },
                { label: "parentProfile.phone.label", property: "phone" },
            ],
            errored: false,
            error: "Error",
            loading: true,
            parentId: this.$route.params.familyId,
        };
    },
    mounted() {
        this.fetchParent();
    },
    methods: {
        async fetchParent() {
            try {
                const response = await axios.get(
                    `api/family_accounts/${this.parentId}`,
                    {
                        headers: {
                            "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                        },
                    }
                );
                this.parent = response.data.data;
                console.log(response.data.data);
            } catch (error) {
                this.errored = true;
                this.error = this.$t("parentProfile.dataLoadingError");
                console.error(this.$t("parentProfile.dataLoadingError"), error);
            } finally {
                this.loading = false;
            }
        },
        getImageSource() {
            if (this.loading || !this.parent.image_data || this.errored) {
                return userDefaultImage;
            } else {
                return `data:image/png;base64,${this.parent.image_data}`;
            }
        },
    },
};
</script>
