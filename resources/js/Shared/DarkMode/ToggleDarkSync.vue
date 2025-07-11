<script setup lang="ts">
import Button from "primevue/button";
import {useThemeToggle} from "@/composables/useThemeToggle";

const {isLightToggle, isDark} = useThemeToggle();
</script>

<template>
  <Button
      :icon="isLightToggle ? 'pi pi-moon' : 'pi pi-sun'"
      severity="secondary"
      outlined
      @click="isLightToggle = !isLightToggle"
  />
</template>

<style scoped>

</style>