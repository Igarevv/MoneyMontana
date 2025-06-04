<script setup lang="ts">
import {ref, onMounted, watch, computed} from 'vue'
import { ToggleSwitch } from 'primevue'
import {getCurrentTheme, switchTheme} from "@/Load/darkMode";

const isDark = ref(false);

onMounted(() => {
  isDark.value = getCurrentTheme() === 'dark'
})

const isLightToggle = computed({
  get: () => !isDark.value,
  set: (val: boolean) => {
    isDark.value = !val;
  }
});


watch(isDark, (newVal) => {
  switchTheme(newVal);
})
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
