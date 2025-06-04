<script setup lang="ts">
import availableLanguages from "@/utils/availableLanguages";
import {Select} from "primevue";
import {useLocaleChange} from "@/composables/useLocaleChange";

export interface Language {
  languageCode: string;
  languageName: string;
}

const locale = useLocaleChange();

</script>

<template>
  <Select
      v-model="locale.currentLocale"
      :options="availableLanguages"
      optionLabel="languageName"
      option-value="languageCode"
      checkmark
      :highlightOnSelect="false"
      class="w-full"
      @change="locale.changeLocale($event.value)"
  />
</template>

<style scoped>

</style>