<template>
  <!-- Activities Start-->
  <div class="container-fluid pt-5">
    <div class="container pb-3">
      <div class="text-center pb-2">
        <p class="section-title px-5">
          <span class="px-2">{{ $t("activities.title") }}</span>
        </p>
        <h1 class="mb-4">{{ $t("activities.tagline") }}</h1>
      </div>
      <div class="row align-items-stretch">
        <div
          v-for="(activity, index) in activities"
          :key="index"
          class="col-lg-4 col-md-6 pb-1"
        >
          <div
            class="d-flex bg-light shadow-sm border-top rounded mb-4"
            style="padding: 30px"
          >
            <i
              :class="
                activity.iconClass + ' h1 font-weight-normal text-primary mb-3'
              "
            ></i>
            <div class="pl-4">
              <h4>
                {{ $t("activities." + activity.translationKey + ".title") }}
              </h4>
              <p class="m-0">
                {{
                  $t("activities." + activity.translationKey + ".description")
                }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Activities End -->
</template>

<script>
import { useI18n } from "vue-i18n";

export default {
  computed: {
    activities() {
      return [
        {
          translationKey: "playground",
          iconClass: "flaticon-010-slide",
        },
        {
          translationKey: "music_and_dance",
          iconClass: "flaticon-027-xylophone",
        },
        {
          translationKey: "arts_and_crafts",
          iconClass: "flaticon-030-crayons",
        },
        {
          translationKey: "developmental_lessons",
          iconClass: "flaticon-040-puzzle",
        },
        {
          translationKey: "healthy_food",
          iconClass: "flaticon-016-apple",
        },
        {
          translationKey: "speech_therapy",
          iconClass: "flaticon-033-blocks",
        },
        {
          translationKey: "english_lessons",
          iconClass: "flaticon-032-book",
        },
        {
          translationKey: "morning_exercises",
          iconClass: "flaticon-018-ball",
        },
        {
          translationKey: "preschool_training",
          iconClass: "flaticon-047-backpack",
        },
      ];
    },
  },
  setup() {
    const { t } = useI18n({ useScope: "global" });
    return { t };
  },
};
</script>

<style>
.align-items-stretch .col-lg-4 {
  display: flex;
  align-items: stretch;
}
</style>
