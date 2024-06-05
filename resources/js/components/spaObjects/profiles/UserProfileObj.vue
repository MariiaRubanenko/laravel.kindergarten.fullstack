<template>
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <div class="image-container">
                        <div
                            class="alert alert-danger mt-3 py-2"
                            role="alert"
                            v-if="validation.image"
                        >
                            {{ validation.image[0] }}
                        </div>
                        <img
                            class="img-fluid-center rounded-fullcircle"
                            :src="imgPreview ? imgPreview : getImageSource()"
                            alt=""
                            @click="$refs.fileInput.click()"
                            style="position: relative"
                        />
                        <div class="overlay" @click="$refs.fileInput.click()">
                            <i class="fas fa-edit edit-icon"></i>
                        </div>
                    </div>

                    <input
                        type="file"
                        @change="onFileSelected"
                        ref="fileInput"
                        style="display: none"
                        accept=".png, .jpg, .jpeg"
                        maxFileSize="1000000"
                    />
                    <div class="mb-5 mb-lg-5" v-if="!imgPreview"></div>

                    <div class="text-center mt-2 mb-4" v-if="imgPreview">
                        <button
                            class="btn btn-primary py-2 px-2.5 mr-2"
                            style="border-radius: 10px"
                            @click="confirmImageChange"
                        >
                            {{ $t("spa.buttons.change") }}
                        </button>
                        <button
                            class="btn btn-danger px-2.5"
                            style="border-radius: 10px"
                            @click="cancelImageChange"
                        >
                            {{ $t("spa.buttons.cancel") }}
                        </button>
                    </div>
                </div>
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
                    <form
                        @submit.prevent="changeUserPhone"
                        novalidate="novalidate"
                    >
                        <h2 style="margin-bottom: 0.75rem; margin-top: 1rem">
                            {{ $t("userProfile.phoneChanging.title") }}
                        </h2>
                        <Textbox
                            v-model="changePhone.newPhone"
                            :type="'text'"
                            :placeholder="
                                $t(
                                    'userProfile.phoneChanging.newPhone.placeholder'
                                )
                            "
                            :required="true"
                            :label="
                                $t('userProfile.phoneChanging.newPhone.label')
                            "
                            :errorMessage="
                                v$.newPhone.$error
                                    ? v$.newPhone.$errors[0].$message
                                    : validation.phone_number
                                    ? validation.phone_number[0]
                                    : ''
                            "
                        />
                        <div class="text-right" style="margin-top: -0.5rem">
                            <button
                                class="btn btn-primary py-2 px-2.5"
                                style="border-radius: 10px"
                                type="submit"
                            >
                                {{ $t("spa.buttons.change") }}
                            </button>
                        </div>
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
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { getCookies } from "@/api/request";

import axios from "axios";
import router from "@/router/router.js";
import InfoBoxLoader from "@/components/Elements/InfoBoxLoader.vue";
import Textbox from "@/components/Elements/TextBox.vue";

import { useVuelidate } from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import { reactive, computed } from "vue";

import userDefaultImage from "@/assets/img/userDefault-light.png";

export default {
    components: { Textbox, InfoBoxLoader },
    setup() {
        const changePhone = reactive({ newPhone: "" });

        const rules = computed(() => {
            return {
                newPhone: {
                    required,
                },
            };
        });

        const v$ = useVuelidate(rules, changePhone);

        return { changePhone, v$ };
    },
    data() {
        return {
            user: {},
            controls: [
                { label: "userProfile.name.label", property: "name" },
                { label: "userProfile.email.label", property: "email" },
                { label: "userProfile.phone.label", property: "phone" },
            ],
            imageData: null,
            imgPreview: null,
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
                const response = await axios.get(
                    `api/staffs/${this.userRoleId}`,
                    {
                        headers: {
                            "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                        },
                    }
                );
                this.user = response.data.data;
                console.log(this.user);
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
        getImageSource() {
            if (this.loading || !this.user.image_data || this.errored) {
                return userDefaultImage;
            } else {
                return `data:image/png;base64,${this.user.image_data}`;
            }
        },
        async changeUserPhone() {
            this.v$.$validate();
            if (!this.v$.$error) {
                try {
                    if (this.userRole == "teacher") {
                        console.log(this.selectedFile);
                        const staffForSending = {
                            user_id: this.user.user_id,
                            group_id: this.user.group_id,
                            phone_number: this.changePhone.newPhone,
                        };
                        await axios.put(
                            `api/staffs/${this.userRoleId}`,
                            staffForSending,
                            {
                                headers: {
                                    "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                                },
                            }
                        );
                    }
                    if (this.userRole == "parent") {
                        const parentForSending = {
                            user_id: this.user.user_id,
                            phone_number: this.changePhone.newPhone,
                        };
                        await axios.put(
                            `api/family_accounts/${this.userRoleId}`,
                            parentForSending,
                            {
                                headers: {
                                    "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                                },
                            }
                        );
                    }
                    router.go();
                } catch (error) {
                    console.error("Error while changing phone:", error);
                    if (error.response.data.error) {
                        this.errored = true;
                        this.error = error.response.data.error;
                    }
                    if (error.response.data.data) {
                        this.validation = error.response.data.data;
                    }
                    if (error.response.data.message) {
                        this.messaged = true;
                        this.message = error.response.data.message;
                    }
                }
            }
        },
        openFileInput() {
            this.$refs.fileInput.click();
        },
        // Отображение выбранного изображения в предпросмотре
        onFileSelected(event) {
            const file = event.target.files[0];

            // Проверка наличия файла
            if (!file) {
                this.errored = true;
                this.error = "No file selected";
                console.error("No file selected");
                return;
            }

            // Проверка типа файла (изображение)
            if (!file.type.startsWith("image/")) {
                this.errored = true;
                this.error = "Selected file is not an image";
                console.error("Selected file is not an image");
                return;
            }

            const reader = new FileReader();
            reader.onload = () => {
                this.imgPreview = reader.result;
            };
            reader.readAsDataURL(file);
        },
        // Подтверждение изменения изображения
        confirmImageChange() {
            this.imageData = this.imgPreview;
            this.changeUserImage();
        },
        // Отмена изменения изображения
        cancelImageChange() {
            this.imgPreview = null;
            this.$refs.fileInput.value = null;
        },
        async changeUserImage() {
            if (!this.imageData) {
                return;
            }
            try {
                let formData = new FormData();
                formData.append("user_id", this.user.user_id);
                formData.append("image", this.imageData);
                if (this.userRole == "teacher") {
                    const response = await axios.put(
                        `api/staffs/${this.userRoleId}`,
                        formData,
                        {
                            headers: {
                                "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                            },
                        }
                    );
                    console.log(response);
                }
                if (this.userRole == "parent") {
                    const response = await axios.put(
                        `api/family_accounts/${this.userRoleId}`,
                        formData,
                        {
                            headers: {
                                "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                            },
                        }
                    );
                    console.log(response.data);
                }
                router.go();
            } catch (error) {
                console.error("Error while uploading photo:", error);
                console.error("Error while uploading photo:", error);
                if (error.response.data.error) {
                    this.errored = true;
                    this.error = error.response.data.error;
                }
                if (error.response.data.data) {
                    this.validation = error.response.data.data;
                }
                if (error.response.data.message) {
                    this.messaged = true;
                    this.message = error.response.data.message;
                }
            }
        },
    },
};
</script>

<style>
.edit-icon:hover {
    color: var(--green-light);
}

.image-container {
    position: relative;
    display: inline-block;
}

.img-fluid-center {
    display: block;
}

.overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.image-container:hover .overlay {
    opacity: 1;
}

.edit-icon {
    color: white;
    font-size: 2em;
}
</style>
