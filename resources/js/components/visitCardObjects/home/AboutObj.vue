<template>
    <!-- About Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="text-center pb-2">
                <p class="section-title px-5">
                    <span class="px-2">{{ $t("about.title") }}</span>
                </p>
                <h1 class="mb-4">{{ $t("about.tagline") }}</h1>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <img
                        class="img-fluid-center rounded mb-5 mb-lg-5"
                        src="@/assets/img/about-4.jpg"
                        alt=""
                    />
                </div>
                <div class="col-lg-7">
                    <p>{{ $t("about.welcome") }}</p>
                    <div class="row pt-2 pb-4">
                        <div class="col-md-12">
                            <ul class="list-inline m-0">
                                <li
                                    class="py-2 border-top border-bottom"
                                    v-for="(item, index) in 10"
                                    :key="index"
                                >
                                    <i class="fa fa-check text-primary mr-3"></i
                                    >{{ $t(`about.list[${index}]`) }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->
</template>
