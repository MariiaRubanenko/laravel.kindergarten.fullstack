<template>
    <div class="row justify-content-center">
        <div class="col-lg-6 mb-5">
            <h2 style="margin-bottom: 2rem">
                {{ $t("appDownload.title") }}
            </h2>
            <div
                class="alert alert-danger mt-3 py-2"
                role="alert"
                v-if="errored"
            >
                {{ error }}
            </div>
            <div
                class="alert alert-danger mt-3 py-2"
                role="alert"
                v-if="messaged"
            >
                {{ message }}
            </div>
            <div
                class="d-flex flex-wrap align-items-start justify-content-between"
            >
                <div class="d-flex align-items-start">
                    <img
                        src="@/assets/img/mobileAppLogo.png"
                        class="mobile-app-logo"
                    />
                    <div class="ml-3 mt-1">
                        <h4>{{ $t("appDownload.app.name") }}</h4>
                        <p>
                            {{ $t("appDownload.app.version") }}<br />{{
                                $t("appDownload.app.date")
                            }}
                        </p>
                    </div>
                </div>
                <button
                    class="btn btn-primary mb-2 px-2.5"
                    style="border-radius: 5px"
                    type="button"
                    @click="downloadApk"
                >
                    {{ $t("appDownload.downloadApk") }}
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { getCookies } from "@/api/request";

export default {
    data() {
        return {
            errored: false,
            error: "",
            messaged: false,
            message: "",
        };
    },
    methods: {
        async downloadApk() {
            try {
                const response = await axios.get("api/download-apk", {
                    headers: {
                        "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                    },
                    responseType: "blob",
                });
                const url = window.URL.createObjectURL(
                    new Blob([response.data])
                );
                const link = document.createElement("a");
                link.href = url;
                link.setAttribute("download", "HappyTimes.apk");
                document.body.appendChild(link);
                link.click();
            } catch (error) {
                this.errored = true;
                this.error = this.$t("loading.bill");
                console.error(this.$t("loading.bill"), error);
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>

<style scoped>
.mobile-app-logo {
    width: 200px;
    height: auto;
    border-radius: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
}

.btn {
    margin-right: 4rem;
}

@media (max-width: 650px) {
    .d-flex.flex-wrap.align-items-start.justify-content-between {
        flex-direction: column;
        align-items: center;
    }

    .btn {
        align-self: flex-end;
        margin-top: 0.5rem;
        margin-right: 1rem;
    }

    .mobile-app-logo {
        width: 100px;
    }
}

@media (max-width: 375px) {
    .d-flex.flex-wrap.align-items-start.justify-content-between {
        flex-direction: column;
        align-items: center;
    }

    .btn {
        align-self: flex-end;
        margin-top: 0.5rem;
        margin-right: 0rem;
    }

    .mobile-app-logo {
        width: 70px;
    }
}
</style>
