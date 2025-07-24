<script setup lang="ts">

function handleAdd() {
  console.log("Add clicked");
}
</script>

<template>
  <div
      @click="handleAdd"
      class="flex items-center justify-center bg-white dark:bg-surface-900 border border-dashed border-gray-300 dark:border-dark-primary-gray hover:bg-primary-yellow/5 cursor-pointer transition-all duration-200 rounded-2xl p-8 min-h-[150px]"
  >
    <div
        class="flex flex-col items-center gap-2 text-surface-500 dark:text-surface-400 hover:text-primary transition-colors duration-200">
      <i class="pi pi-plus text-2xl"></i>
      <span class="font-medium text-sm">Add new</span>
    </div>
  </div>
</template>

<style scoped>

</style>
