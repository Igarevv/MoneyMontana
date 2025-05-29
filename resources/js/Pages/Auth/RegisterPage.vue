<script setup lang="ts">
import RegisterForm from "@Modules/Auth/resources/views/components/Registration/RegisterForm.vue";
import PromoPanel from "@Modules/Auth/resources/views/components/Registration/PromoPanel.vue";
</script>

<template>
  <main class="flex min-h-screen">
    <div class="hidden md:block w-1/2">
      <PromoPanel />
    </div>
    <div class="w-full md:w-1/2 flex justify-center items-center">
      <RegisterForm />
    </div>
  </main>
</template>

<style scoped>

</style>