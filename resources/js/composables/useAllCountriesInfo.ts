// composables/useCountries.ts
import {ref} from 'vue'
import {Country} from "@Modules/Auth/resources/views/components/Registration/Steps/UserPreferencesForm.vue";

let allCountries: any[] = []

export function useAllCountriesInfo() {
    const countries = ref<Country[]>([]);

    const currencies = ref<string[]>([]);

    const loaded = ref(false);

    async function loadCountries() {
        if (allCountries.length > 0) {
            countries.value = allCountries;

            currencies.value = getUniqueCurrencies(allCountries);

            loaded.value = true;

            return;
        }

        const data = await import('@/Meta/countries.json');

        allCountries = data.default.country.map((item: any) => ({
            ...item,
            label: `${item.countryName} (${item.currencyCode})`,
        }));

        countries.value = allCountries;

        currencies.value = getUniqueCurrencies(allCountries);

        loaded.value = true;
    }

    function getUniqueCurrencies(countries: any[]) {
        const seen = new Set<string>();

        for (const country of countries) {
            if (country.currencyCode) {
                seen.add(country.currencyCode);
            }
        }

        return Array.from(seen).sort();
    }

    return {
        countries,
        currencies,
        loaded,
        loadCountries,
    }
}
