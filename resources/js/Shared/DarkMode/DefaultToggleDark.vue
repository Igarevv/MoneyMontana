<script setup lang="ts">
import { ToggleSwitch } from 'primevue'
import {useThemeToggle} from "@/composables/useThemeToggle";

const { isLightToggle } = useThemeToggle();
</script>

<template>
  <ToggleSwitch v-model="isLightToggle">
    <template #handle="{ checked }">
      <i :class="['!text-xs pi', { 'pi-sun': checked, 'pi-moon': !checked }]" />
    </template>
  </ToggleSwitch>
</template>

<style scoped>
:root,
.dark {
  transition: background-color 0.3s, color 0.3s;
}
</style>
