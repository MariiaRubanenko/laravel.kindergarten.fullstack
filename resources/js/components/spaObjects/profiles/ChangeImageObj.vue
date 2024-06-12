<template>
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

        <div class="alert alert-danger mt-3 py-2" role="alert" v-if="errored">
            {{ error }}
        </div>
        <div class="alert alert-danger mt-3 py-2" role="alert" v-if="messaged">
            {{ message }}
        </div>
    </div>
</template>

<script>
import userDefaultImage from "@/assets/img/userDefault-light.png";
import { getCookies } from "@/api/request";
import axios from "axios";
import router from "@/router/router.js";

export default {
    props: {
        user: {
            type: Object,
            required: true,
        },
        userRole: {
            type: String,
            required: true,
        },
        userRoleId: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            imageData: null,
            imgPreview: null,
            validation: {},
        };
    },
    methods: {
        getImageSource() {
            if (!this.user.image_data) {
                return userDefaultImage;
            } else {
                return `data:image/png;base64,${this.user.image_data}`;
            }
        },
        onFileSelected(event) {
            const file = event.target.files[0];

            if (!file) {
                this.$emit("error", "No file selected");
                return;
            }

            if (!file.type.startsWith("image/")) {
                this.$emit("error", "Selected file is not an image");
                return;
            }

            const reader = new FileReader();
            reader.onload = () => {
                this.imgPreview = reader.result;
            };
            reader.readAsDataURL(file);
        },
        confirmImageChange() {
            this.imageData = this.imgPreview;
            this.changeUserImage();
        },
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
                if (this.userRole === "teacher") {
                    await axios.put(`api/staffs/${this.userRoleId}`, formData, {
                        headers: {
                            "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                        },
                    });
                }
                if (this.userRole === "parent") {
                    await axios.put(
                        `api/family_accounts/${this.userRoleId}`,
                        formData,
                        {
                            headers: {
                                "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                            },
                        }
                    );
                }
                localStorage.setItem("userProfilePhoto", this.imageData);
                this.$emit("refresh-main");
            } catch (error) {
                console.error("Error while uploading photo:", error);
                if (error.response.data.error) {
                    this.$emit("error", error.response.data.error);
                }
                if (error.response.data.data) {
                    this.validation = error.response.data.data;
                }
                if (error.response.data.message) {
                    this.$emit("error", error.response.data.message);
                }
            }
        },
    },
};
</script>

<style scoped>
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
