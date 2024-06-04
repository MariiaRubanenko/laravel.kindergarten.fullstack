<template>
    <div class="row justify-content-center">
        <div class="col-lg-10 mb-5">
            <h2 style="margin-bottom: 0.75rem">
                {{ $t("сhildrenWithoutGroup.title") }}
            </h2>
            <div class="alert alert-danger py-2" role="alert" v-if="errored">
                {{ error }}
            </div>
            <div
                class="alert alert-warning py-2"
                role="alert"
                v-if="children.length == 0 && !loading && !errored"
            >
                {{ $t("сhildrenWithoutGroup.dataNo") }}
            </div>
            <div
                class="output-group"
                v-for="(child, index) in children"
                :key="index"
            >
                <div class="outputBox" @click="redirectToChild(child.id)">
                    {{ child.name }}
                </div>
                <button
                    class="btn btn-primary ml-2 px-4"
                    style="border-radius: 5px"
                    type="button"
                    @click="addChild(child.id)"
                >
                    {{ $t("spa.buttons.add") }}
                </button>
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
            children: [],
            loading: true,
            errored: false,
            error: "Error",
            groupId: this.$route.params.groupId,
        };
    },
    mounted() {
        this.fetchChildren();
    },
    methods: {
        async fetchChildren() {
            try {
                const response = await axios.get(`api/children_without_group`, {
                    headers: {
                        "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                    },
                });
                this.children = response.data.data;
                console.log(response.data.data);
            } catch (error) {
                this.errored = true;
                this.error = this.$t("сhildrenWithoutGroup.dataLoadingError");
                console.error(
                    this.$t("сhildrenWithoutGroup.dataLoadingError"),
                    error
                );
            } finally {
                this.loading = false;
            }
        },
        async addChild(childId) {
            try {
                const response = await axios.get(
                    `api/child_profiles/${childId}`,
                    {
                        headers: {
                            "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                        },
                    }
                );
                const childToUpdate = response.data.data;

                const childForSending = {
                    name: childToUpdate.name,
                    gender: childToUpdate.gender,
                    birthday: childToUpdate.birthday,
                    group_id: this.groupId,
                    family_account_id: childToUpdate.family_account_id,
                };
                console.log(childForSending);

                await axios.put(
                    `api/child_profiles/${childId}`,
                    childForSending,
                    {
                        headers: {
                            "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                        },
                    }
                );
                router.go();
            } catch (error) {
                this.errored = true;
                this.error = this.$t("сhildrenWithoutGroup.addError");
                console.error(this.$t("сhildrenWithoutGroup.addError"), error);
            }
        },
        redirectToChild(childId) {
            router.push({ path: `/childProfile/${childId}` });
        },
        closeModal() {
            this.showModal = false;
        },
    },
};
</script>
