<script setup lang="ts">
import {ref} from 'vue';
import AutoComplete from 'primevue/autocomplete';
import {ToggleSwitch} from "primevue";
import DefaultSelectLocalization from "@/Shared/Localization/DefaultSelectLocalization.vue";
import {useLocaleChange} from "@/composables/useLocaleChange";
import {useI18n} from "vue-i18n";
import DefaultToggleDark from "@/Shared/DarkMode/DefaultToggleDark.vue";

export interface Country {
  countryCode: string;
  countryName: string;
  currencyCode: string;
  population: string;
  capital: string;
  continentName: string;
  label: string;
}

const { t } = useI18n();

const selectedCountry = ref<Country | null>(null);

const { currentLocale } = useLocaleChange();

const selectedCurrency = ref<string | null>(null);

const filteredCountries = ref<Country[]>([]);

let allCountries: Country[] = [];

async function loadCountries() {
  if (allCountries.length > 0) {
    return;
  }

  const data = await import('@/Meta/countries.json');

  allCountries = data.default.country.map((item: any) => ({
    ...item,
    label: `${item.countryName} (${item.currencyCode})`
  }));
}

async function searchCountry(event: { query: string }) {
  await loadCountries();

  const query = event.query.toLowerCase();

  filteredCountries.value = allCountries
      .filter(c =>
          c.countryName.toLowerCase().includes(query) ||
          c.currencyCode.toLowerCase().includes(query) ||
          c.capital.toLowerCase().includes(query)
      );
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
              v-model="selectedCountry"
              :suggestions="filteredCountries"
              @complete="searchCountry"
              optionLabel="countryName"
              :placeholder="t('registration.setup_preferences.country_placeholder')"
              dropdown
              class="w-full"
          />
          <i class="pi pi-check" :class="selectedCountry !== null ? 'text-green-500' : 'text-gray-800'"></i>
        </div>
      </div>

      <div class="flex flex-col w-full">
        <label class="text-base text-black dark:text-white">
          {{ t('registration.setup_preferences.language_label') }}
        </label>
        <div class="flex flex-row items-center gap-3">
          <default-select-localization />
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
      </div>

      <div class="flex flex-row gap-3">
        <span>{{ t('registration.setup_preferences.theme_mode') }}</span>
        <default-toggle-dark/>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>