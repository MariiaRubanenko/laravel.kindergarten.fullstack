<template>
    <div class="row justify-content-center">
        <div class="col-lg-6 mb-2">
            <h2 style="margin-bottom: 0.75rem">
                {{ $t("familyChildren.title") }}
            </h2>

            <div class="alert alert-danger py-2" role="alert" v-if="errored">
                {{ error }}
            </div>
            <div
                class="alert alert-warning py-2"
                role="alert"
                v-if="children.length == 0 && !loading && !errored"
            >
                {{ $t("familyChildren.dataNo") }}
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
                    class="btn btn-danger ml-2 px-2.5"
                    style="border-radius: 5px"
                    type="button"
                    @click="showCustomConfirmation(child.id)"
                >
                    {{ $t("spa.buttons.delete") }}
                </button>
            </div>
            <InfoLoader :loading="loading" />
        </div>

        <ConfirmationMenu
            :showModal="showModal"
            :message="$t('familyChildren.deleteMessage')"
            :buttonConfirm="$t('spa.buttons.delete')"
            :buttonCancel="$t('spa.buttons.cancel')"
            @confirm="deleteChildConfirm"
            @cancel="cancelDelete"
        />
    </div>
</template>

<script>
import axios from "axios";
import router from "@/router/router.js";

import { getCookies } from "@/api/request";

import ConfirmationMenu from "@/components/Elements/ConfirmationMenu.vue";
import InfoLoader from "@/components/Elements/InfoLoader.vue";

export default {
    components: {
        ConfirmationMenu,
        InfoLoader,
    },
    data() {
        return {
            children: [],
            showModal: false,
            childToDeleteId: null,
            loading: true,
            errored: false,
            error: "Error",
            familyId: this.$route.params.familyId,
        };
    },
    mounted() {
        this.fetchChildren();
    },
    methods: {
        async fetchChildren() {
            try {
                const response = await axios.get(
                    `api/family_accounts/${this.familyId}`,
                    {
                        headers: {
                            "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                        },
                    }
                );
                this.children = response.data.data.child_profiles;
                console.log(response.data.data.child_profiles);
            } catch (error) {
                this.errored = true;
                this.error = this.$t("familyChildren.dataLoadingError");
                console.error(
                    this.$t("familyChildren.dataLoadingError"),
                    error
                );
            } finally {
                this.loading = false;
            }
        },
        async deleteChild(childId) {
            try {
                await axios.delete(`api/child_profiles/${childId}`, {
                    headers: {
                        "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                    },
                });
                this.closeModal();
                router.go();
            } catch (error) {
                this.errored = true;
                this.error = this.$t("familyChildren.deleteError");
                console.error(this.$t("familyChildren.deleteError"), error);
            }
        },
        showCustomConfirmation(childId) {
            this.childToDeleteId = childId;
            this.showModal = true;
        },
        deleteChildConfirm() {
            this.deleteChild(this.childToDeleteId);
            this.closeModal();
        },
        cancelDelete() {
            this.childToDeleteId = null;
            this.showModal = false;
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
