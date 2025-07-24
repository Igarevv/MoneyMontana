<script setup lang="ts">
import {useI18n} from "vue-i18n";
import ExpenseCard from "@Modules/ExpenseAccount/resources/views/components/Expenses/ExpenseCard.vue";
import ExpenseAddCard from "@Modules/ExpenseAccount/resources/views/components/Expenses/Add/ExpenseAddCard.vue";

const {t} = useI18n();
</script>

<template>
  <div class="bg-surface-50 dark:bg-surface-950 p-20">
    <div class="bg-white dark:bg-surface-900 p-6 shadow rounded-2xl flex flex-col gap-4">
      <div class="flex gap-4">
        <div class="flex flex-col gap-2 flex-1">
          <div class="text-2xl leading-tight font-semibold text-surface-900 dark:text-surface-0">{{
              t('panel.expense_accounting.all_expenses.title')
            }}
          </div>
        </div>
      </div>
      <div class="flex flex-1 w-full">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-4 w-full">
          <expense-card/>
          <expense-card/>
          <expense-card/>
          <expense-card/>
          <expense-card/>
          <expense-add-card/>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>