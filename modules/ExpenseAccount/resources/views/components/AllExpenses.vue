<script setup lang="ts">
import {useI18n} from "vue-i18n";

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
      <div class="flex flex-1">
        <div class="flex-1 border-2 border-dashed border-surface-200 dark:border-surface-700 rounded-lg h-[150px]"/>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>