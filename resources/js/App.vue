<template>
    <div class="app">
        <router-view />
    </div>
</template>

<script>
import { useI18n } from "vue-i18n";

export default {
    setup() {
        const { t } = useI18n({ useScope: "global" });
        return { t };
    },
};
</script>

<style></style>
