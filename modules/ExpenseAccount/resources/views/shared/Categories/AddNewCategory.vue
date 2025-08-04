<script setup lang="ts">
import {reactive} from "vue";
import {yupResolver} from "@primevue/forms/resolvers/yup";
import * as yup from "yup";
import {Form} from "@primevue/forms";
import InputText from "primevue/inputtext";
import RadioButtonGroup from "primevue/radiobuttongroup";
import RadioButton from "primevue/radiobutton"
import axios from "axios";

export type ICreateExpenseCategory = {
  category_name: string
  color: string
}

const initialValues = reactive({
  category_name: '',
  color: '',
});

const resolver = yupResolver(
    yup.object({
      category_name: yup.string().required(),
      color: yup.string(),
    })
);

const tailwind100Colors = [
  '#fef3c7', '#ffedd5', '#fee2e2', '#fce7f3', '#f3e8ff',
  '#e9d5ff', '#ddd6fe', '#dbeafe', '#bae6fd', '#cffafe',
  '#ccfbf1', '#d1fae5', '#dcfce7', '#f0fdf4', '#fef9c3',
  '#fde68a', '#e5e5e5', '#e0e7ff', '#f1f5f9', '#e2e8f0',
]

const onSubmit = ({valid, values}: { valid: boolean, values: ICreateExpenseCategory }) => {
  if (valid) {
    axios.post('/api/montana/expense-categories', {
      category_name: values.category_name,
      color: values.color,
    })
        .then((response) => {
          console.log(response)
        })
        .catch((error) => {
        })
  }
}
</script>

<template>
  <div class="w-72 p-4 rounded-xl">
    <Form v-slot="$form" :resolver="resolver" :initial-values="initialValues" class="space-y-2" @submit="onSubmit">
      <div class="flex flex-col gap-2">
        <label class="block text-sm font-medium text-gray-700">
          {{ $t('panel.expense_accounting.all_expenses.add_form.expense_disposable.form.category_name') }}
        </label>
        <InputText
            name="category_name"
            id="category_name"
            size="small"
            :variant="'filled'"
        >
        </InputText>
      </div>
      <div class="flex flex-col gap-2">
        <div class="flex gap-2 items-center">
          <label class="text-sm font-medium text-gray-700">
            {{ $t('panel.expense_accounting.all_expenses.add_form.expense_disposable.form.color') }}
          </label>
          <span class="size-3" :style="{ backgroundColor: $form.color?.value}"></span>
        </div>
        <RadioButtonGroup name="color" class="grid grid-cols-6 gap-2 max-h-40 overflow-y-auto mb-4">
          <label
              v-for="color in tailwind100Colors"
              :key="color"
              class="cursor-pointer"
          >
            <RadioButton
                type="radio"
                name="color"
                class="!hidden peer"
                :input-id="`color-${color}`"
                :value="color"
            />
            <div
                class="w-8 h-8 rounded-full border-2 border-transparent peer-checked:border-primary-dark"
                :style="{ backgroundColor: color }"
            />
          </label>
        </RadioButtonGroup>
      </div>
      <button
          type="submit"
          class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-md text-xs"
      >
        {{ $t('panel.expense_accounting.all_expenses.add_form.expense_disposable.form.create') }}
      </button>
    </Form>
  </div>
</template>

<style scoped>

</style>
