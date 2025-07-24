<script setup lang="ts">
import InputNumber from "primevue/inputnumber";
import FloatLabel from "primevue/floatlabel";
</script>

<template>
  <div class="flex">
    <FloatLabel variant="on">
      <InputNumber inputId="on_label" mode="currency" currency="USD" locale="en-US"/>
      <label for="on_label">Amount</label>
    </FloatLabel>
    <Select v-model="selectedCity" :options="cities" optionLabel="name" placeholder="Select a City"
            class="w-full md:w-56"/>
  </div>
</template>

<style scoped>

</style>