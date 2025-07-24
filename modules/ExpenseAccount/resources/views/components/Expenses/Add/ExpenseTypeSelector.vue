<script setup lang="ts">
import {defineEmits, defineProps} from 'vue'

const props = defineProps<{
  selected: ExpenseType
}>()

const emit = defineEmits<{
  (e: 'update:selected', value: ExpenseType): void
}>()

function select(value: ExpenseType) {
  emit('update:selected', value)
}
</script>

<template>
  <div class="flex gap-4 m-8">
    <div
        v-for="type in [ExpenseType.DISPOSABLE, ExpenseType.SUBSCRIPTION, ExpenseType.REPEATABLE]"
        :key="type"
        @click="select(type)"
        :class="[
        'flex-1 min-w-[12rem] rounded-xl p-4 hover:cursor-pointer relative border-2',
        selected === type ? 'border-blue-600' : 'border-gray-300'
      ]"
    >
      <div class="font-semibold text-gray-900">
        {{ $t(`panel.expense_accounting.all_expenses.add_form.expense_${type}.label`) }}
      </div>
      <div class="text-sm text-gray-500 mt-1">
        {{ $t(`panel.expense_accounting.all_expenses.add_form.expense_${type}.description`) }}
      </div>
      <div
          v-if="selected === type"
          class="absolute top-2 right-2 w-5 h-5 rounded-full bg-blue-600 flex items-center justify-center"
      >
        <svg class="w-3 h-3 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="20 6 9 17 4 12"/>
        </svg>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
export enum ExpenseType {
  DISPOSABLE = 'disposable',
  SUBSCRIPTION = 'subscription',
  REPEATABLE = 'repeatable'
}
</script>
