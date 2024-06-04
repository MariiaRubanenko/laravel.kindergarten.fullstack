<template>
    <div class="row justify-content-center">
        <div class="col-lg-10 mb-5">
            <h2 style="margin-bottom: 0.75rem">
                {{ $t("groupChildren.title") }}
            </h2>
            <div class="alert alert-danger py-2" role="alert" v-if="errored">
                {{ error }}
            </div>
            <div
                class="alert alert-warning py-2"
                role="alert"
                v-if="children.length == 0 && !loading && !errored"
            >
                {{ $t("groupChildren.dataNo") }}
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
                    v-if="userRole === 'admin'"
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
            :message="$t('groupChildren.deleteMessage')"
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
            groupId: this.$route.params.groupId,
            userRole: localStorage.getItem("userRole"),
        };
    },
    mounted() {
        this.fetchChildren();
    },
    methods: {
        async fetchChildren() {
            try {
                const response = await axios.get(`api/groups/${this.groupId}`, {
                    headers: {
                        "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                    },
                });
                this.children = response.data.data.child_profiles;
                console.log(response.data.data.child_profiles);
            } catch (error) {
                this.errored = true;
                this.error = this.$t("groupChildren.dataLoadingError");
                console.error(this.$t("groupChildren.dataLoadingError"), error);
            } finally {
                this.loading = false;
            }
        },
        async deleteChild(childId) {
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
                    group_id: null,
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

                this.closeModal();
                router.go();
            } catch (error) {
                this.errored = true;
                this.error = this.$t("groupChildren.deleteError");
                console.error(this.$t("groupChildren.deleteError"), error);
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
        closeModal() {
            this.showModal = false;
        },
        redirectToChild(childId) {
            router.push({ path: `/childProfile/${childId}` });
        },
    },
};
</script>
