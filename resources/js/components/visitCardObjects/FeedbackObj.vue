<template>
    <div class="row justify-content-center">
        <div class="col-lg-6 col-9">
            <div class="text-center pb-2">
                <p class="section-title px-5">
                    <span class="px-2">{{ $t("feedback.title") }}</span>
                </p>
                <h1 class="mb-4">{{ $t("feedback.tagline") }}</h1>
            </div>
            <div class="alert alert-danger py-2" role="alert" v-if="errored">
                {{ error }}
            </div>
            <div
                class="alert alert-warning py-2"
                role="alert"
                v-if="comments.length == 0 && !loading && !errored"
            >
                {{ $t("feedback.dataNo") }}
            </div>
            <div
                v-for="(comment, index) in comments"
                :key="index"
                class="row align-items-start d-flex justify-content-center trusted-person-container"
            >
                <div class="col-lg-3">
                    <img
                        class="img-fluid-center side-rounded-fullcircle mt-2 mb-4 mb-lg-2 mt-lg-2"
                        :src="getImageSource(comment)"
                        alt=""
                    />
                </div>
                <div class="col-lg-9 mt-lg-4">
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
                                    {{ comment[control.property] || "-" }}
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
import axios from "axios";
import InfoBoxLoader from "@/components/Elements/InfoBoxLoader.vue";
import InfoLoader from "@/components/Elements/InfoLoader.vue";

import userDefaultImage from "@/assets/img/userDefault-light.png";

export default {
    components: { InfoBoxLoader, InfoLoader },
    data() {
        return {
            comments: [],
            controls: [
                { label: "feedback.comments.name.label", property: "name" },
                {
                    label: "feedback.comments.date.label",
                    property: "created_at",
                },
                { label: "feedback.comments.comment.label", property: "text" },
            ],
            errored: false,
            error: "Error",
            loading: true,
        };
    },
    mounted() {
        this.fetchComments();
    },
    methods: {
        async fetchComments() {
            try {
                const response = await axios.get(`comments`);
                this.comments = response.data.data;
                console.log(response.data.data);
            } catch (error) {
                this.errored = true;
                this.error = this.$t("feedback.dataLoadingError");
                console.error(this.$t("feedback.dataLoadingError"), error);
            } finally {
                this.loading = false;
            }
        },
        getImageSource(comment) {
            if (this.loading || !comment.image_data || this.errored) {
                return userDefaultImage;
            } else {
                return `data:image/png;base64,${comment.image_data}`;
            }
        },
    },
};
</script>
