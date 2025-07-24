<script setup lang="ts">
import {computed, ref} from 'vue';
import AutoComplete from 'primevue/autocomplete';
import DefaultSelectLocalization from "@/Shared/Localization/DefaultSelectLocalization.vue";
import {useLocaleChange} from "@/composables/useLocaleChange";
import {useI18n} from "vue-i18n";
import DefaultToggleDark from "@/Shared/DarkMode/DefaultToggleDark.vue";
import Button from "primevue/button";
import Select from 'primevue/select';
import {useAllCountriesInfo} from "@/composables/useAllCountriesInfo";

export interface Country {
  countryCode: string;
  countryName: string;
  currencyCode: string;
  population: string;
  capital: string;
  continentName: string;
  label: string;
}

export interface EmploymentType {
  label: string;
  value: string;
}

const {t, tm} = useI18n();
const {currentLocale} = useLocaleChange();

const props = defineProps<{
  nextStep: Function;
  errors: { country?: string, currency?: string, employment_type?: string };
}>();

const emit = defineEmits<{
  (e: 'register', value: { country: string; currency: string, employmentType: string }): void;
}>();

const employmentOptions = tm('registration.setup_preferences.employment_type') as Array<{
  label: string,
  value: string
}>

const selectedCurrency = ref<Country | null>(null);

const selectedCountry = ref<Country | null>(null);

const selectedEmploymentType = ref(
    employmentOptions.find(opt => opt.value === t('registration.setup_preferences.employment_type.2.value'))
);

const countryTouched = ref(false);
const currencyTouched = ref(false);

const isCountryInvalid = computed(() => countryTouched.value && !selectedCountry.value);
const isCurrencyInvalid = computed(() => currencyTouched.value && !selectedCurrency.value);

const filteredCountries = ref<Country[]>([]);

const {countries, loadCountries} = useAllCountriesInfo();

async function searchCountry(event: { query: string }) {
  await loadCountries();

  const query = event.query.toLowerCase();

  filteredCountries.value = countries.value.filter(c =>
      c.countryName.toLowerCase().includes(query) ||
      c.currencyCode.toLowerCase().includes(query) ||
      c.capital.toLowerCase().includes(query)
  );
}

function onRegister() {
  countryTouched.value = true;

  currencyTouched.value = true;

  if (selectedCountry.value && selectedCurrency.value && selectedEmploymentType.value) {
    emit('register', {
      country: selectedCountry.value.countryCode,
      currency: selectedCurrency.value.currencyCode,
      employmentType: selectedEmploymentType.value.value
    });
    props.nextStep(3);
  }
}

function onCountryChange(country: Country | null) {
  selectedCountry.value = country;
  if (country) {
    selectedCurrency.value = country;
  }
}
</script>

<template>
  <div class="w-full max-w-md p-8 space-y-6 dark:bg-primary-dark">
    <h2 class="text-2xl font-bold text-black dark:text-white text-center">
      {{ t('registration.setup_preferences.title') }}
    </h2>
    <div class="space-y-6 flex items-center flex-col">
      <div class="flex flex-col w-full">
        <label class="text-base text-black dark:text-white">
          {{ t('registration.setup_preferences.country_label') }}
        </label>
        <div class="flex flex-row items-center gap-3 w-full">
          <AutoComplete
              :modelValue="selectedCountry"
              :suggestions="filteredCountries"
              @update:modelValue="onCountryChange"
              @complete="searchCountry"
              optionLabel="countryName"
              :placeholder="t('registration.setup_preferences.country_placeholder')"
              dropdown
              class="w-full"
              @blur="countryTouched = true"
          />
          <i class="pi pi-check" :class="selectedCountry !== null ? 'text-green-500' : 'text-gray-800'"></i>
        </div>
        <p v-if="isCountryInvalid" class="text-sm text-red-500 mt-1">
          {{ t('registration.register.errors.country_required') }}
        </p>
        <p v-else-if="errors?.country" class="text-sm text-red-500 mt-1">
          {{ errors.country }}
        </p>
      </div>

      <div class="flex flex-col w-full">
        <label class="text-base text-black dark:text-white">
          {{ t('registration.setup_preferences.language_label') }}
        </label>
        <div class="flex flex-row items-center gap-3">
          <default-select-localization/>
          <i class="pi pi-check" :class="currentLocale !== null ? 'text-green-500' : 'text-gray-800'"></i>
        </div>
      </div>

      <div class="flex flex-col w-full">
        <label class="text-base text-black dark:text-white">
          {{ t('registration.setup_preferences.currency_label') }}
        </label>
        <div class="flex flex-row items-center gap-3 w-full">
          <AutoComplete
              v-model="selectedCurrency"
              :suggestions="filteredCountries"
              @complete="searchCountry"
              optionLabel="currencyCode"
              :placeholder="t('registration.setup_preferences.currency_placeholder')"
              class="w-full"
              dropdown
              @blur="currencyTouched = true"
          >
            <template #option="slotProps">
              <div class="flex flex-col">
                <span class="font-semibold">{{ slotProps.option.currencyCode }}</span>
                <small class="text-gray-500">
                  {{ t('registration.setup_preferences.currency_country_prefix') }} {{ slotProps.option.countryName }}
                </small>
              </div>
            </template>
          </AutoComplete>
          <i class="pi pi-check" :class="selectedCountry !== null ? 'text-green-500' : 'text-gray-800'"></i>
        </div>
        <p v-if="isCurrencyInvalid" class="text-sm text-red-500 mt-1">
          {{ t('registration.register.errors.currency_required') }}
        </p>
        <p v-else-if="errors?.currency" class="text-sm text-red-500 mt-1">
          {{ errors.currency }}
        </p>
      </div>

      <div class="flex flex-col w-full">
        <label class="text-base text-black dark:text-white">
          {{ t('registration.setup_preferences.employment_type_label') }}
        </label>
        <div class="flex flex-row items-center gap-3 w-full">
          <Select
              v-model="selectedEmploymentType"
              :options="employmentOptions"
              optionLabel="label"
              class="w-full"
          >
          </Select>
          <i class="pi pi-check" :class="selectedEmploymentType !== null ? 'text-green-500' : 'text-gray-800'"></i>
        </div>
        <p v-if="errors?.employment_type" class="text-sm text-red-500 mt-1">
          {{ errors.employment_type }}
        </p>
      </div>

      <div class="flex flex-row gap-3">
        <span>{{ t('registration.setup_preferences.theme_mode') }}</span>
        <default-toggle-dark/>
      </div>
    </div>
  </div>
  <div class="flex pt-6 justify-between">
    <Button label="Back" severity="secondary" icon="pi pi-arrow-left" @click="nextStep(1)"/>
    <Button label="Register Now!" @click="onRegister"/>
  </div>
</template>

<style scoped>
:deep(.p-autocomplete-input::placeholder) {
  @apply text-gray-400
}
</style>