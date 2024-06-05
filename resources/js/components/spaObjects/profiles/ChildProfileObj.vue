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
                        {{ $t("child.title") }}
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
                                {{ child[control.property] || "-" }}
                            </template>
                        </div>
                    </div>
                    <div>
                        <button
                            class="btn btn-primary py-2"
                            style="border-radius: 10px; width: 100%"
                            @click="
                                redirectToTrustedPersons(
                                    child.family_account_id
                                )
                            "
                        >
                            {{ $t("child.trustedPersonButton") }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { getCookies } from "@/api/request";

import axios from "axios";
import router from "@/router/router.js";
import InfoBoxLoader from "@/components/Elements/InfoBoxLoader.vue";

import maleChildDefaultImage from "@/assets/img/childPhotoDefault-male.png";

import femaleChildDefaultImage from "@/assets/img/childPhotoDefault-female.png";

export default {
    components: { InfoBoxLoader },
    data() {
        return {
            child: {},
            controls: [
                { label: "child.name.label", property: "name" },
                { label: "child.gender.label", property: "gender" },
                { label: "child.birth.label", property: "birthday" },
                { label: "child.allergies.label", property: "allergies" },
                { label: "child.diseases.label", property: "illnesses" },
            ],
            errored: false,
            error: "Error",
            loading: true,
            childId: this.$route.params.childId,
        };
    },
    mounted() {
        this.fetchChild();
    },
    methods: {
        async fetchChild() {
            try {
                const response = await axios.get(
                    `api/child_profiles/${this.childId}`,
                    {
                        headers: {
                            "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                        },
                    }
                );
                this.child = response.data.data;
                console.log(response.data.data);
            } catch (error) {
                this.errored = true;
                this.error = this.$t("child.dataLoadingError");
                console.error(this.$t("child.dataLoadingError"), error);
            } finally {
                this.loading = false;
            }
        },
        redirectToTrustedPersons(familyId) {
            router.push({ path: `/trustedPersons/${familyId}` });
        },
        getImageSource() {
            if (this.loading || !this.child.image_data || this.errored) {
                // Возвращаем путь к фото по умолчанию
                if (this.child.gender === "male") {
                    return maleChildDefaultImage;
                } else {
                    return femaleChildDefaultImage;
                }
            } else {
                return `data:image/png;base64,${this.child.image_data}`;
            }
        },
    },
};
</script>
