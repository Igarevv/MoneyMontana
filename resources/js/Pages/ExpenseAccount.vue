<script setup lang="ts">
import PanelLayout from "@/Layouts/PanelLayout.vue";
import Stats from "@Modules/ExpenseAccount/resources/views/components/Stats.vue";
import AllExpenses from "@Modules/ExpenseAccount/resources/views/components/Expenses/AllExpenses.vue";

defineOptions({
  layout: PanelLayout
})
</script>

<template>
  <stats/>
  <all-expenses/>
</template>
