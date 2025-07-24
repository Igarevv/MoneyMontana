<script setup lang="ts">
import InputNumber from "primevue/inputnumber";
import FloatLabel from "primevue/floatlabel";
import {useAllCountriesInfo} from "@/composables/useAllCountriesInfo";
import {onMounted, ref} from "vue";
import {usePreferences} from "@/composables/usePreferences";
import Select from "primevue/select";
import DatePicker from "primevue/datepicker";

const {loadCountries, currencies} = useAllCountriesInfo();

const date = ref<Date | null>(new Date());

const selectedCurrency = ref(usePreferences().currency);

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
    <div class="flex gap-4">
      <FloatLabel variant="on" class="w-1/2">
        <InputNumber inputId="on_label" mode="currency" :currency="selectedCurrency" locale="en-US" class="w-full"/>
        <label for="on_label">{{ $t('panel.expense_accounting.all_expenses.add_form.amount_label') }}</label>
      </FloatLabel>
      <Select v-model="selectedCurrency" :options="currencies" class="w-28"/>
    </div>

    <div class="flex gap-4 items-center">
      <FloatLabel variant="on">
        <DatePicker v-model="date" inputId="date" showIcon iconDisplay="input"/>
        <label for="date">{{ $t('panel.expense_accounting.all_expenses.add_form.expense_disposable.date') }}</label>
      </FloatLabel>

      <span
          v-if="isFutureDate(date)"
          class="text-xs">{{
          $t('panel.expense_accounting.all_expenses.add_form.expense_disposable.date_in_future')
        }}</span>
    </div>
  </div>
</template>

<style scoped>

</style>