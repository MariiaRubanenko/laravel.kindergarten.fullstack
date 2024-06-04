<template>
  <div class="row justify-content-center">
    <div class="col-lg-6 mb-5">
      <h2 style="margin-bottom: 0.75rem">
        {{ $t("settings.languages.title") }}
      </h2>
      <div v-for="(lang, key) in languages" :key="key" class="language-box">
        <div class="language-info">{{ $t(lang.name) }}</div>
        <label class="switch">
          <input
            type="radio"
            :value="lang.code"
            v-model="selectedLanguage"
            @change="toggleLanguage(lang.code)"
          />
          <span class="slider round"></span>
        </label>
      </div>
    </div>
  </div>
</template>

<script>
import { useI18n } from "vue-i18n";

export default {
  setup() {
    const { t, locale } = useI18n({ useScope: "global" });

    const languages = [
      { code: "en", name: "settings.languages.english.name" },
      { code: "ua", name: "settings.languages.ukrainian.name" },
    ];

    const savedLang = localStorage.getItem("lang");
    if (savedLang) {
      locale.value = savedLang;
    }

    let selectedLanguage = locale.value;

    const toggleLanguage = (langCode) => {
      if (langCode === selectedLanguage) return;
      selectedLanguage = langCode;
      locale.value = langCode;
      localStorage.setItem("lang", langCode);
    };

    return { t, languages, selectedLanguage, toggleLanguage };
  },
};
</script>

<style scoped>
.language-box {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
  font-size: 1.5rem;
  font-weight: 400;
  line-height: 1.5;
  color: #495057;
  background-color: var(--yellow-light-box);
  background-clip: padding-box;
  border: 1px solid var(--grey-border);
  border-radius: 5px;
  transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.language-info {
  margin-left: 1rem;
}

.switch {
  position: relative;
  display: inline-block;
  margin-right: 1rem;
  margin-top: 0.5rem;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: 0.4s;
  transition: 0.4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: 0.4s;
  transition: 0.4s;
}

input:checked + .slider {
  background-color: var(--green-light);
}

input:focus + .slider {
  box-shadow: 0 0 1px var(--green-light);
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
