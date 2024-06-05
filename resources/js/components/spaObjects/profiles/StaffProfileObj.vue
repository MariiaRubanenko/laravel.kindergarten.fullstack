<template>
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <img
                        class="img-fluid-center rounded-fullcircle mb-5 mb-lg-5"
                        :src="getImageSource()"
                        alt=""
                    />
                </div>
                <div class="col-lg-7">
                    <h2 style="margin-bottom: 0.75rem">
                        {{ $t("staff.title") }}
                    </h2>
                    <div
                        class="alert alert-danger mb-3 py-2"
                        role="alert"
                        v-if="errored"
                    >
                        {{ error }}
                    </div>
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
                                {{ staff[control.property] || "-" }}
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { getCookies } from "@/api/request";

import axios from "axios";
import InfoBoxLoader from "@/components/Elements/InfoBoxLoader.vue";

import teacherDefaultImage from "@/assets/img/teacherPhotoDefault.png";

export default {
    components: { InfoBoxLoader },
    data() {
        return {
            staff: {},
            controls: [
                { label: "staff.name.label", property: "name" },
                { label: "staff.email.label", property: "email" },
                { label: "staff.phone.label", property: "phone" },
            ],
            errored: false,
            error: "Error",
            loading: true,
            staffId: this.$route.params.staffId,
        };
    },
    mounted() {
        this.fetchStuff();
    },
    methods: {
        async fetchStuff() {
            try {
                const response = await axios.get(`api/staffs/${this.staffId}`, {
                    headers: {
                        "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                    },
                });
                this.staff = response.data.data;
                console.log(response.data.data);
            } catch (error) {
                this.errored = true;
                this.error = this.$t("staff.dataLoadingError");
                console.error(this.$t("staff.dataLoadingError"), error);
            } finally {
                this.loading = false;
            }
        },
        getImageSource() {
            if (this.loading || !this.staff.image_data || this.errored) {
                return teacherDefaultImage;
            } else {
                return `data:image/png;base64,${this.staff.image_data}`;
            }
        },
    },
};
</script>
