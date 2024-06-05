<template>
    <div class="row justify-content-center">
        <div class="col-lg-6 mb-5">
            <h2 style="margin-bottom: 0.75rem">
                {{ $t("families.title") }}
            </h2>
            <div class="alert alert-danger py-2" role="alert" v-if="errored">
                {{ error }}
            </div>
            <div
                class="alert alert-warning py-2"
                role="alert"
                v-if="families.length == 0 && !loading && !errored"
            >
                {{ $t("familyChildren.dataNo") }}
            </div>
            <div
                class="output-group"
                v-for="(family, index) in families"
                :key="index"
            >
                <div
                    class="outputBox"
                    @click="redirectToFamily(family.family_account_id)"
                >
                    {{ family.name }}
                </div>
                <button
                    class="btn btn-danger ml-2 px-2.5"
                    style="border-radius: 5px"
                    type="button"
                    @click="showCustomConfirmation(family.family_account_id)"
                >
                    {{ $t("spa.buttons.delete") }}
                </button>
            </div>
            <InfoLoader :loading="loading" />
        </div>

        <ConfirmationMenu
            :showModal="showModal"
            :message="$t('families.deleteMessage')"
            :buttonConfirm="$t('spa.buttons.delete')"
            :buttonCancel="$t('spa.buttons.cancel')"
            @confirm="deleteFamilyConfirm"
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
            families: [],
            showModal: false,
            familyToDelete: null,
            loading: true,
            errored: false,
            error: "Error",
        };
    },
    mounted() {
        this.fetchFamilies();
    },
    methods: {
        async fetchFamilies() {
            try {
                const response = await axios.get("api/family_accounts", {
                    headers: {
                        "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                    },
                });
                this.families = response.data.data;
                console.log(response.data);
            } catch (error) {
                this.errored = true;
                this.error = this.$t("families.dataLoadingError");
                console.error(this.$t("families.dataLoadingError"), error);
            } finally {
                this.loading = false;
            }
        },
        async deleteFamily(familyId) {
            try {
                const family = this.families.find(
                    (family) => family.family_account_id === familyId
                );
                const userId = family.user_id;

                await axios.delete(`api/users/${userId}`, {
                    headers: {
                        "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                    },
                });

                this.families = this.families.filter(
                    (family) => family.family_account_id !== familyId
                );
                this.closeModal();
                router.go();
            } catch (error) {
                this.errored = true;
                this.error = this.$t("families.deleteError");
                console.error(this.$t("families.deleteError"), error);
            }
        },
        showCustomConfirmation(familyId) {
            this.familyToDelete = familyId;
            this.showModal = true;
        },
        deleteFamilyConfirm() {
            this.deleteFamily(this.familyToDelete);
            this.closeModal();
        },
        cancelDelete() {
            this.familyToDelete = null;
            this.showModal = false;
        },
        redirectToFamily(familyId) {
            router.push({ path: `/childrenOfFamily/${familyId}` });
        },
        closeModal() {
            this.showModal = false;
        },
    },
};
</script>
