<template>
    <!-- Header Start -->
    <div class="container-fluid bg-primary px-0 px-md-5 mb-5">
        <div class="row align-items-center px-3">
            <div class="col-lg-6 text-center text-lg-left">
                <h4 class="text-white mb-4 mt-5 mt-lg-0">
                    {{ $t("homeHeader.title") }}
                </h4>
                <h1 class="display-3 font-weight-bold text-white">
                    {{ $t("homeHeader.tagline") }}
                </h1>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <img
                    class="img-fluid-header mt-5"
                    src="@/assets/img/header_home.png"
                    alt=""
                />
            </div>
        </div>
    </div>
    <!-- Header End -->
</template>

<script>
export default {};
</script>

<style></style>
