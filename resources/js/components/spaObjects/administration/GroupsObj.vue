<template>
    <div class="row justify-content-center">
        <div class="col-lg-6 mb-5">
            <h2 style="margin-bottom: 0.75rem">
                {{ $t("groups.title") }}
            </h2>
            <div class="alert alert-danger py-2" role="alert" v-if="errored">
                {{ error }}
            </div>
            <div
                class="alert alert-warning py-2"
                role="alert"
                v-if="groups.length == 0 && !loading && !errored"
            >
                {{ $t("groupChildren.dataNo") }}
            </div>
            <div
                class="output-group"
                v-for="(group, index) in groups"
                :key="index"
            >
                <div class="outputBox" @click="redirectToGroup(group.id)">
                    {{ group.name }}
                </div>
                <button
                    class="btn btn-danger ml-2 px-2.5"
                    style="border-radius: 5px"
                    type="button"
                    @click="showCustomConfirmation(group.id)"
                >
                    {{ $t("spa.buttons.delete") }}
                </button>
            </div>
            <InfoLoader :loading="loading" />
        </div>

        <ConfirmationMenu
            :showModal="showModal"
            :message="$t('groups.deleteMessage')"
            :buttonConfirm="$t('spa.buttons.delete')"
            :buttonCancel="$t('spa.buttons.cancel')"
            @confirm="deleteGroupConfirm"
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
            groups: [],
            showModal: false,
            groupToDelete: null,
            loading: true,
            errored: false,
            error: "Error",
        };
    },
    mounted() {
        this.fetchGroups();
    },
    methods: {
        async fetchGroups() {
            try {
                const response = await axios.get("api/groups", {
                    headers: {
                        "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                    },
                });
                this.groups = response.data.data;
                console.log(response.data);
            } catch (error) {
                this.errored = true;
                this.error = this.$t("groups.dataLoadingError");
                console.error(this.$t("groups.dataLoadingError"), error);
            } finally {
                this.loading = false;
            }
        },
        async deleteGroup(groupId) {
            try {
                await axios.delete(`api/groups/${groupId}`, {
                    headers: {
                        "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                    },
                });
                this.closeModal();
                this.$emit("refresh-main");
            } catch (error) {
                this.errored = true;
                this.error = this.$t("groups.deleteError");
                console.error(this.$t("groups.deleteError"), error);
            }
        },
        showCustomConfirmation(groupId) {
            this.groupToDelete = groupId;
            this.showModal = true;
        },
        deleteGroupConfirm() {
            this.deleteGroup(this.groupToDelete);
            this.closeModal();
        },
        cancelDelete() {
            this.groupToDelete = null;
            this.showModal = false;
        },
        redirectToGroup(groupId) {
            router.push({ path: `/groupChildren/${groupId}` });
        },
        closeModal() {
            this.showModal = false;
        },
    },
};
</script>
