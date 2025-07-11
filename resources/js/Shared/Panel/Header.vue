<script setup lang="ts">
import {inject, provide, ref} from "vue";
import Button from "primevue/button";

const visible = inject<boolean>('visible');
</script>

<template>
  <header class="p-4 border">
    <div class="flex gap-2 items-center justify-between">
      <h1 class="text-xl font-bold">Dashboard</h1>
      <Button icon="pi pi-bars" @click="visible = true" severity="secondary"/>
    </div>
  </header>
</template>

<style scoped>

</style>