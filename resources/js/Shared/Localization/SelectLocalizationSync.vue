<script setup lang="ts">
import availableLanguages from "@/utils/availableLanguages";
import {Select} from "primevue";
import {useLocaleChange} from "@/composables/useLocaleChange";
import {onMounted, ref} from "vue";

export interface Language {
  languageCode: string;
  languageName: string;
}

defineProps({
  size: {
    type: String,
    default: undefined
  }
});

const locale = useLocaleChange();

const isMobile = ref(false);

onMounted(() => {
  isMobile.value = window.innerWidth <= 768;
});
</script>

<template>
  <Select
      v-model="locale.currentLocale"
      :options="availableLanguages"
      optionLabel="languageName"
      option-value="languageCode"
      checkmark
      :highlightOnSelect="false"
      class="w-full h-full"
      @change="locale.changeLocale($event.value)"
  >
    <template #value="slotProps">
      <span v-if="isMobile" class="pi pi-language"/>
    </template>
    <template #option="slotProps">
      <span :class="size === 'small' ? 'text-sm' : ''">
        {{ slotProps.option.languageName }}
      </span>
    </template>
  </Select>
</template>

<style scoped>

</style>