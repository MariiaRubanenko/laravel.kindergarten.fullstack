<template>
    <img
        v-if="userRole === 'teacher' || userRole === 'parent'"
        class="profile-image mr-3"
        :src="getImageSource()"
        alt=""
        @click="redirectUserProfile()"
    />
</template>

<script>
import { getCookies } from "@/api/request";
import axios from "axios";
import router from "@/router/router";

import userDefaultImage from "@/assets/img/userDefault.png";

export default {
    data() {
        return {
            user: {},
            errored: false,
            error: "Error",
            loading: true,
            userId: localStorage.getItem("userRoleId"),
            userRole: localStorage.getItem("userRole"),
        };
    },
    mounted() {
        if (this.userRole == "teacher") {
            this.fetchStuff();
        }
        if (this.userRole == "parent") {
            this.fetchParent();
        }
    },
    methods: {
        async fetchStuff() {
            try {
                const response = await axios.get(`api/staffs/${this.userId}`, {
                    headers: {
                        "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                    },
                });
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
                    `api/family_accounts/${this.userId}`,
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
        getImageSource() {
            if (this.loading || !this.user.image_data || this.errored) {
                return userDefaultImage;
            } else {
                return `data:image/png;base64,${this.user.image_data}`;
            }
        },
        redirectUserProfile() {
            router.push({ path: `/userProfile/${this.userId}` });
        },
    },
};
</script>
