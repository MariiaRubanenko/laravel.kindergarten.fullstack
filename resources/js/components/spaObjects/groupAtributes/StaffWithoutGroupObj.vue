<template>
    <div class="row justify-content-center">
        <div class="col-lg-10 mb-5">
            <h2 style="margin-bottom: 0.75rem">
                {{ $t("staffsWithoutGroup.title") }}
            </h2>
            <div class="alert alert-danger py-2" role="alert" v-if="errored">
                {{ error }}
            </div>
            <div
                class="alert alert-warning py-2"
                role="alert"
                v-if="staffs.length == 0 && !loading && !errored"
            >
                {{ $t("staffsWithoutGroup.dataNo") }}
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
                    class="btn btn-primary ml-2 px-2.5"
                    style="border-radius: 5px"
                    type="button"
                    @click="addStaff(staff.id)"
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
            staffs: [],
            loading: true,
            errored: false,
            error: "Error",
            groupId: this.$route.params.groupId,
        };
    },
    mounted() {
        this.fetchStaffs();
    },
    methods: {
        async fetchStaffs() {
            try {
                const response = await axios.get(`api/staffs_without_group`, {
                    headers: {
                        "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                    },
                });
                this.staffs = response.data.data;
                console.log(response.data.data);
            } catch (error) {
                this.errored = true;
                this.error = this.$t("staffsWithoutGroup.dataLoadingError");
                console.error(
                    this.$t("staffsWithoutGroup.dataLoadingError"),
                    error
                );
            } finally {
                this.loading = false;
            }
        },
        async addStaff(staffId) {
            try {
                const response = await axios.get(`api/staffs/${staffId}`, {
                    headers: {
                        "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                    },
                });
                const staffToUpdate = response.data.data;

                const staffForSending = {
                    user_id: staffToUpdate.user_id,
                    group_id: this.groupId,
                };
                console.log(staffForSending);

                await axios.put(`api/staffs/${staffId}`, staffForSending, {
                    headers: {
                        "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                    },
                });
                this.$emit("refresh-main");
            } catch (error) {
                this.errored = true;
                this.error = this.$t("staffsWithoutGroup.addError");
                console.error(this.$t("staffsWithoutGroup.addError"), error);
            }
        },
        redirectToStaff(staffId) {
            router.push({ path: `/staffProfile/${staffId}` });
        },
        closeModal() {
            this.showModal = false;
        },
    },
};
</script>
