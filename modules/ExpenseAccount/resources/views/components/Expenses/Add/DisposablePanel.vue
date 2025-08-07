<script setup lang="ts">
import InputNumber from "primevue/inputnumber";
import FloatLabel from "primevue/floatlabel";
import {useAllCountriesInfo} from "@/composables/useAllCountriesInfo";
import {onMounted} from "vue";
import Select from "primevue/select";
import DatePicker from "primevue/datepicker";
import CategoriesTags from "@Modules/ExpenseAccount/resources/views/shared/Categories/CategoriesTags.vue";
import Message from "primevue/message";

const props = defineProps({
  form: Object
})

const {loadCountries, currencies} = useAllCountriesInfo();

const isFutureDate = (date: Date | null) => {
  if (!date) {
    return false;
  }

  const today = new Date();

  return date.getTime() > today.getTime();
}

onMounted(() => {
  loadCountries();
})
</script>

<template>
  <div class="flex flex-col gap-8">
    <div class="flex flex-col gap-2">
      <div class="flex gap-4">
        <FloatLabel variant="on" class="w-1/2">
          <InputNumber
              v-model="form.amount"
              inputId="on_label"
              mode="currency"
              :currency="form.currency"
              locale="en-US"
              class="w-full"
          />
          <label for="on_label">{{ $t('panel.expense_accounting.all_expenses.add_form.amount_label') }}</label>
        </FloatLabel>
        <Select v-model="form.currency" :options="currencies" class="w-28"/>
      </div>
      <Message time="5000" severity="error" size="small" variant="simple" v-if="form.errors.amount">{{
          form.errors.amount
        }}
      </Message>
      <Message time="5000" severity="error" size="small" variant="simple" v-if="form.errors.currency">{{
          form.errors.currency
        }}
      </Message>
    </div>

    <div class="flex flex-col gap-2">
      <div class="flex gap-4 items-center">
        <FloatLabel variant="on">
          <DatePicker v-model="form.created_at" inputId="date" showIcon iconDisplay="input"/>
          <label for="date">{{ $t('panel.expense_accounting.all_expenses.add_form.expense_disposable.date') }}</label>
        </FloatLabel>

        <span
            v-if="isFutureDate(form.created_at)"
            class="text-xs">{{
            $t('panel.expense_accounting.all_expenses.add_form.expense_disposable.date_in_future')
          }}</span>
      </div>
      <Message time="5000" severity="error" size="small" variant="simple" v-if="form.errors.created_at">{{
          form.errors.created_at
        }}
      </Message>
    </div>

    <div class="flex gap-2 flex-col">
      <div class="space-y-4">
        <span>{{ $t('panel.expense_accounting.all_expenses.add_form.expense_disposable.category') }}</span>
        <categories-tags @selected-categories="(categories: number[]) => form.categories = categories"/>
      </div>
      <Message time="5000" severity="error" size="small" variant="simple" v-if="form.errors.categories">{{
          form.errors.categories
        }}
      </Message>
    </div>
  </div>
</template>

<style scoped>

</style>