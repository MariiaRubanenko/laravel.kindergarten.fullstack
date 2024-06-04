<template>
    <div class="row justify-content-center">
        <div class="col-lg-10 mb-5">
            <h2 style="margin-bottom: 0.75rem">
                {{ $t("groupStaffs.title") }}
            </h2>
            <div class="alert alert-danger py-2" role="alert" v-if="errored">
                {{ error }}
            </div>
            <div
                class="alert alert-warning py-2"
                role="alert"
                v-if="staffs.length == 0 && !loading && !errored"
            >
                {{ $t("groupStaffs.dataNo") }}
            </div>
            <div
                class="output-group"
                v-for="(staff, index) in staffs"
                :key="index"
            >
                <div class="outputBox" @click="redirectToStaff(staff.id)">
                    {{ staff.name }}
                </div>
                <button
                    v-if="userRole === 'admin'"
                    class="btn btn-danger ml-2 px-2.5"
                    style="border-radius: 5px"
                    type="button"
                    @click="showCustomConfirmation(staff.id)"
                >
                    {{ $t("spa.buttons.delete") }}
                </button>
            </div>
            <InfoLoader :loading="loading" />
        </div>

        <ConfirmationMenu
            :showModal="showModal"
            :message="$t('groupStaffs.deleteMessage')"
            :buttonConfirm="$t('spa.buttons.delete')"
            :buttonCancel="$t('spa.buttons.cancel')"
            @confirm="deleteStaffConfirm"
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
            staffs: [],
            showModal: false,
            staffToDeleteId: null,
            loading: true,
            errored: false,
            error: "Error",
            groupId: this.$route.params.groupId,
            userRole: localStorage.getItem("userRole"),
        };
    },
    mounted() {
        this.fetchStaffs();
    },
    methods: {
        async fetchStaffs() {
            try {
                const response = await axios.get(`api/groups/${this.groupId}`, {
                    headers: {
                        "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                    },
                });
                this.staffs = response.data.data.staffs;
                console.log(response.data.data.staffs);
            } catch (error) {
                this.errored = true;
                this.error = this.$t("groupStaffs.dataLoadingError");
                console.error(this.$t("groupStaffs.dataLoadingError"), error);
            } finally {
                this.loading = false;
            }
        },
        async deleteStaff(staffId) {
            try {
                const response = await axios.get(`api/staffs/${staffId}`, {
                    headers: {
                        "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                    },
                });
                const staffToUpdate = response.data.data;

                //Составляем объект для отправки
                const staffForSending = {
                    user_id: staffToUpdate.user_id,
                    group_id: null,
                };
                console.log(staffForSending);

                // Отправляем запрос на обновление данных ребенка
                await axios.put(`api/staffs/${staffId}`, staffForSending, {
                    headers: {
                        "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                    },
                });

                this.closeModal();
                router.go();
            } catch (error) {
                this.errored = true;
                this.error = this.$t("groupStaffs.deleteError");
                console.error(this.$t("groupStaffs.deleteError"), error);
            }
        },
        showCustomConfirmation(staffId) {
            this.staffToDeleteId = staffId;
            this.showModal = true;
        },
        deleteStaffConfirm() {
            this.deleteStaff(this.staffToDeleteId);
            this.closeModal();
        },
        cancelDelete() {
            this.staffToDeleteId = null;
            this.showModal = false;
        },
        redirectToStaff(staffId) {
            router.push({ path: `/StaffProfile/${staffId}` });
        },
        closeModal() {
            this.showModal = false;
        },
    },
};
</script>
