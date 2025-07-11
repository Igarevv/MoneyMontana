<script setup lang="ts">
import {inject} from "vue";
import Drawer from 'primevue/drawer';
import AppLogoDark from "@/Shared/AppLogoDark.vue";

const visible = inject<boolean>('visible', false);
</script>

<template>
  <Drawer v-model:visible="visible">
    <template #container="{ closeCallback }">
      <div class="flex flex-col h-full">
        <div class="flex items-center justify-center px-6 pt-4 shrink-0">
          <div class="inline-flex items-center gap-2">
            <AppLogoDark/>
          </div>
        </div>
        <div class="overflow-y-auto">

        </div>
        <div class="mt-auto">
          <hr class="mb-4 mx-4 border-t border-0 border-surface-200 dark:border-surface-700"/>
        </div>
      </div>
    </template>
  </Drawer>
</template>

<style scoped>

</style>