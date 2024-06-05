<template>
  <!-- Footer Start -->
  <div
    class="container-fluid bg-secondary text-white-footer mt-5 py-5 px-sm-3 px-md-5"
  >
    <div class="row pt-0">
      <!-- Get In Touch -->
      <div class="col-lg-12 mb-4 text-center">
        <h1 class="text-primary mb-2">{{ $t("footer.info.title") }}</h1>
        <div class="row justify-content-center">
          <div class="col-md-4">
            <div class="d-flex align-items-center justify-content-center">
              <h4
                class="fa fa-map-marker-alt text-primary"
                style="margin-bottom: 4rem"
              ></h4>
              <div class="pl-3">
                <h3 class="text-white-footer mb-0">
                  {{ $t("footer.info.address") }}
                </h3>
                <p class="mb-0">{{ $t("footer.info.adressInfo1") }}</p>
                <p class="mb-0">{{ $t("footer.info.adressInfo2") }}</p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="d-flex align-items-center justify-content-center">
              <h4
                class="fa fa-envelope text-primary"
                style="margin-bottom: 4rem"
              ></h4>
              <div class="pl-3">
                <h3 class="text-white-footer mb-0">
                  {{ $t("footer.info.email") }}
                </h3>
                <a
                  class="text-white-footer mb-0"
                  href="mailto:nykyta.lisovyi@nure.ua"
                  style="font-size: 1.25em"
                  >nykyta.lisovyi@nure.ua</a
                >
                <p class="mb-0 mt-0"></p>
                <a
                  class="text-white-footer mb-0"
                  href="mailto:mariia.rubanenko@nure.ua"
                  style="font-size: 1.25em"
                  >mariia.rubanenko@nure.ua</a
                >
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="d-flex align-items-center justify-content-center">
              <h4
                class="fa fa-phone-alt text-primary"
                style="margin-bottom: 4rem"
              ></h4>
              <div class="pl-3">
                <h3 class="text-white-footer ml-0 mb-0">
                  {{ $t("footer.info.phone") }}
                </h3>
                <a
                  class="text-white-footer mb-0"
                  href="tel:+380 123 456 789"
                  style="font-size: 1.25em"
                  >+380 123 456 789</a
                >
                <p class="mb-0 mt-0"></p>
                <a
                  class="text-white-footer mb-0"
                  href="tel:+380 987 654 321"
                  style="font-size: 1.25em"
                  >+380 987 654 321</a
                >
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Quick Links -->
    <div class="row pt-3">
      <div class="col-lg-12 mb-4 text-center">
        <h1 class="text-primary mb-2">{{ $t("footer.pages.title") }}</h1>
        <div class="d-flex flex-wrap justify-content-center">
          <router-link to="/" class="text-white-footer mr-4 mb-2">
            <i class="fa fa-angle-right mr-2"></i>{{ $t("footer.pages.home") }}
          </router-link>
          <router-link to="/location" class="text-white-footer mr-4 mb-2">
            <i class="fa fa-angle-right mr-2"></i
            >{{ $t("footer.pages.location") }}
          </router-link>
          <router-link to="/feedback" class="text-white-footer mr-4 mb-2">
            <i class="fa fa-angle-right mr-2"></i
            >{{ $t("footer.pages.feedback") }}
          </router-link>
        </div>
      </div>
    </div>
    <!-- Social Media Links -->
    <div class="row pt-1">
      <div class="col text-center">
        <a
          class="btn btn-outline-primary rounded-circle text-center mr-2 px-0"
          style="font-size: 34px; width: 60px; height: 60px"
          href="https://t.me/nure_press"
          ><i class="fab fa-telegram"></i
        ></a>
        <a
          class="btn btn-outline-primary rounded-circle text-center mr-2 px-0"
          style="font-size: 35px; width: 60px; height: 60px"
          href="https://www.facebook.com/nureKharkiv/"
          ><i class="fab fa-facebook-f"></i
        ></a>
        <a
          class="btn btn-outline-primary rounded-circle text-center mr-2 px-0"
          href="https://www.instagram.com/khnure_official/"
          style="font-size: 35px; width: 60px; height: 60px"
          ><i class="fab fa-instagram"></i
        ></a>
      </div>
    </div>
    <!-- Copyright -->
    <div
      class="container-fluid pt-4"
      style="border-top: 1px solid rgba(129, 199, 46, 0.2); margin-top: 2rem"
    >
      <p class="m-0 text-center text-white">
        &copy;
        <a class="text-primary font-weight-bold" href="#">Happy Times</a>. All
        Rights Reserved. Designed by
        <a class="text-primary font-weight-bold" href="https://nure.ua/"
          >Nure students</a
        >
      </p>
    </div>
  </div>
  <!-- Footer End -->
</template>

<script>
export default {};
</script>

<style></style>
