import { SupportedLocales } from "@/i18n.config";
import { ref } from "vue";
import availableLanguages from "@/utils/availableLanguages";
import Cookies from "js-cookie";
import { useI18n } from "vue-i18n";

export function useLocaleChange() {
    const { locale: i18nLocale } = useI18n();

    const currentLocale = ref<SupportedLocales>(
        (Cookies.get('locale') as SupportedLocales) || SupportedLocales.EN
    );

    const availableCodes = availableLanguages.map(lang => lang.languageCode);

    const changeLocale = (newLocale: string) => {
        if (availableCodes.includes(newLocale)) {
            Cookies.set('locale', newLocale, {
                expires: 365,
                path: '/',
                sameSite: 'Lax',
                secure: false
            });

            currentLocale.value = newLocale as SupportedLocales;

            i18nLocale.value = newLocale;
        } else {
            console.warn(`Locale ${newLocale} is not supported.`);
        }
    };

    return {
        currentLocale,
        changeLocale
    };
}