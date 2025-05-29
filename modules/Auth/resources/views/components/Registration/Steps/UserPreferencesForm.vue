<script setup lang="ts">
import {ref} from 'vue';
import AutoComplete from 'primevue/autocomplete';
import {Select} from "primevue";
import availableLanguages from "@/utils/availableLanguages";
import {ToggleSwitch} from "primevue";

export interface Country {
  countryCode: string;
  countryName: string;
  currencyCode: string;
  population: string;
  capital: string;
  continentName: string;
  label: string;
}

export interface Language {
  languageCode: string;
  languageName: string;
}

const selectedCountry = ref<Country | null>(null);

const selectedLanguage = ref<Language | null>(availableLanguages[0]);

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
  <div class="w-full max-w-md p-8 space-y-6">
    <h2 class="text-2xl font-bold text-black dark:text-white text-center">Let us setup your preferences</h2>
    <div class="space-y-6 flex items-center flex-col">
      <div class="flex flex-col w-full">
        <label class="text-base text-black dark:text-white">Your country</label>
        <div class="flex flex-row items-center gap-3 w-full">
          <AutoComplete
              v-model="selectedCountry"
              :suggestions="filteredCountries"
              @complete="searchCountry"
              optionLabel="countryName"
              placeholder="Ukraine..."
              dropdown
              class="w-full"
          />
          <i class="pi pi-check" :class="selectedCountry !== null ? 'text-green-500' : 'text-gray-800'"></i>
        </div>
      </div>
      <div class="flex flex-col w-full">
        <label class="text-base text-black dark:text-white">Your preferred language</label>
        <div class="flex flex-row items-center gap-3">
          <Select
              v-model="selectedLanguage"
              :options="availableLanguages"
              optionLabel="languageName"
              checkmark
              :highlightOnSelect="false"
              class="w-full"
          />
          <i class="pi pi-check" :class="selectedLanguage !== null ? 'text-green-500' : 'text-gray-800'"></i>
        </div>
      </div>
      <div class="flex flex-col w-full">
        <label class="text-base text-black dark:text-white">Your preferred currency</label>
        <div class="flex flex-row items-center gap-3 w-full">
          <AutoComplete
              v-model="selectedCurrency"
              :suggestions="filteredCountries"
              @complete="searchCountry"
              optionLabel="currencyCode"
              placeholder="USD"
              class="w-full"
              dropdown
          >
            <template #option="slotProps">
              <div class="flex flex-col">
                <span class="font-semibold">{{ slotProps.option.currencyCode }}</span>
                <small class="text-gray-500">
                  Country: {{ slotProps.option.countryName }}
                </small>
              </div>
            </template>
          </AutoComplete>
          <i class="pi pi-check" :class="selectedLanguage !== null ? 'text-green-500' : 'text-gray-800'"></i>
        </div>
      </div>
      <div class="flex flex-row gap-3">
        <span>Theme Mode</span>
        <ToggleSwitch>
          <template #handle="{ checked }">
            <i :class="['!text-xs pi', { 'pi-sun': checked, 'pi-moon': !checked }]" />
          </template>
        </ToggleSwitch>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>