<script setup lang="ts">
import {inject} from "vue";
import Button from "primevue/button";
import ToggleDarkSync from "@/Shared/DarkMode/ToggleDarkSync.vue";
import SelectLocalizationSync from "@/Shared/Localization/SelectLocalizationSync.vue";

defineProps({
  title: String ?? 'Default Title'
})

const visible = inject<boolean>('visible');
</script>

<template>
  <header class="sticky-top p-4 border-b dark:border-dark-primary-gray">
    <div class="flex gap-2 items-center justify-between">
      <h1 class="text-xl font-bold">{{ title }}</h1>
      <div class="flex gap-2 items-center">
        <select-localization-sync class="h-full"/>
        <toggle-dark-sync class="shrink-0"/>
        <Button icon="pi pi-bars" class="shrink-0" @click="visible = true" severity="secondary" outlined/>
      </div>
    </div>
  </header>
</template>

<style scoped>

</style>