<template>
    <div class="row justify-content-center">
        <div class="col-lg-6 mb-5">
            <div class="container">
                <h2 class="mb-4">{{ $t("appDescription.title") }}</h2>
                <div class="row align-items-center">
                    <div class="col-lg-7">
                        <p>{{ $t("appDescription.text") }}</p>
                        <div class="row pt-2 pb-4">
                            <div class="col-md-12">
                                <ul class="list-inline m-0">
                                    <li
                                        class="py-2 border-top border-bottom"
                                        v-for="(item, index) in 6"
                                        :key="index"
                                    >
                                        <i
                                            class="fa fa-check text-primary mr-3"
                                        ></i
                                        >{{
                                            $t(`appDescription.list[${index}]`)
                                        }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 ml-lg-6">
                        <img
                            class="img-fluid-center rounded ml-lg-6"
                            style="max-height: 520px"
                            src="@/assets/img/mobile-app1.png"
                            alt=""
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
