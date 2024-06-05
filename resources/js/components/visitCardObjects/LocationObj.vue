<template>
  <!-- Location Start -->
  <div class="container-fluid py-5">
    <div class="container">
      <div class="text-center pb-2">
        <p class="section-title px-5">
          <span class="px-2">{{ $t("location.title") }}</span>
        </p>
        <h1 class="mb-4">{{ $t("location.tagline") }}</h1>
      </div>
      <div class="row align-items-center">
        <div class="col-lg-6">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5127.584563718403!2d36.222207158691404!3d50.0152484!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4127a1aa42fd5ec1%3A0x5792470f834a4fe8!2z0KXQndCj0KDQrQ!5e0!3m2!1suk!2sua!4v1709841436026!5m2!1suk!2sua"
            width="100%"
            height="500"
            style="border: 6; border-color: #81c72e; border-style: solid"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
          ></iframe>
        </div>
        <div class="col-lg-6 mt-2">
          <p>{{ $t("location.info1") }}</p>
          <p>{{ $t("location.info2") }}</p>
          <p>{{ $t("location.info3") }}</p>
          <p>{{ $t("location.info4") }}</p>
        </div>
      </div>
    </div>
  </div>
  <!-- Location End -->
</template>

<script></script>

<stile></stile>
