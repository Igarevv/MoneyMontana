<script setup lang="ts">
import PromoPanel from "@Modules/Auth/resources/views/components/Registration/PromoPanel.vue";
import LoginForm from "@Modules/Auth/resources/views/components/Login/LoginForm.vue";
import {ref} from "vue";
import SpeedDial from "primevue/speeddial"
import {useLocaleChange} from "@/composables/useLocaleChange";
import {useThemeToggle} from "@/composables/useThemeToggle";

const theme = useThemeToggle();

const { cycleLocale } = useLocaleChange();

const items = ref([
  {
    label: 'Change Language',
    icon: 'pi pi-language',
    command: () => {
      cycleLocale();
    }
  },
  {
    label: 'Update',
    icon: theme.isDark ? 'pi pi-sun' : 'pi pi-moon',
    command: () => {
      theme.toggleDark();
    }
  }
]);
</script>

<template>
  <main class="flex min-h-screen">
    <div class="hidden md:block w-1/2">
      <PromoPanel />
    </div>
    <div class="relative w-full md:w-1/2 flex justify-center items-center">
      <LoginForm/>
      <SpeedDial
          :model="items"
          :radius="120"
          direction="left"
          :style="{ position: 'absolute', bottom: '1rem', right: '1rem' }"
      />
    </div>
  </main>
</template>

<style scoped>

</style>