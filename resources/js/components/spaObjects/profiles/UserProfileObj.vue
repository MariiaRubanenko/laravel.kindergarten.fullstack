<template>
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row align-items-center">
                <ChangeImageObj
                    :user="user"
                    :userRole="userRole"
                    :userRoleId="userRoleId"
                    @refresh-main="refreshMain"
                />
                <div class="col-lg-7">
                    <h2 style="margin-bottom: 0.75rem">
                        {{ $t("userProfile.title") }}
                    </h2>
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
                                {{ user[control.property] || "-" }}
                            </template>
                        </div>
                    </div>
                    <ChangePhoneObj
                        :user="user"
                        :userRole="userRole"
                        :userRoleId="userRoleId"
                        @refresh-main="refreshMain"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { getCookies } from "@/api/request";
import axios from "axios";
//import router from "@/router/router.js";
import InfoBoxLoader from "@/components/Elements/InfoBoxLoader.vue";
import ChangeImageObj from "@/components/spaObjects/profiles/ChangeImageObj.vue";
import ChangePhoneObj from "@/components/spaObjects/profiles/ChangePhoneObj.vue";

export default {
    components: { InfoBoxLoader, ChangeImageObj, ChangePhoneObj },
    data() {
        return {
            user: {},
            controls: [
                { label: "userProfile.name.label", property: "name" },
                { label: "userProfile.email.label", property: "email" },
                { label: "userProfile.phone.label", property: "phone" },
            ],
            errored: false,
            error: "Error",
            messaged: false,
            message: "",
            validation: {},
            loading: true,
            userRole: localStorage.getItem("userRole"),
            userRoleId: this.$route.params.userId,
        };
    },
    mounted() {
        if (this.userRole === "teacher") {
            this.fetchStaff();
        } else if (this.userRole === "parent") {
            this.fetchParent();
        }
    },
    props: {
        refreshMain: {
            type: Function,
            required: true,
        },
    },
    methods: {
        async fetchStaff() {
            try {
                const response = await axios.get(
                    `api/staffs/${this.userRoleId}`,
                    {
                        headers: {
                            "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                        },
                    }
                );
                this.user = response.data.data;
            } catch (error) {
                this.errored = true;
                this.error = this.$t("loading.user");
                console.error(this.$t("loading.user"), error);
            } finally {
                this.loading = false;
            }
        },
        async fetchParent() {
            try {
                const response = await axios.get(
                    `api/family_accounts/${this.userRoleId}`,
                    {
                        headers: {
                            "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                        },
                    }
                );
                this.user = response.data.data;
            } catch (error) {
                this.errored = true;
                this.error = this.$t("loading.user");
                console.error(this.$t("loading.user"), error);
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>
