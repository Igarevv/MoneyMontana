import { ref, computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import { useI18n } from "vue-i18n";
import Cookies from "js-cookie";
import availableLanguages from "@/utils/availableLanguages";
import { SupportedLocales } from "@/i18n.config";

export function useLocaleChange() {
    const page = usePage();

    const { locale: i18nLocale } = useI18n();

    const currentLocale = ref<SupportedLocales>(
        (page.props.locale as SupportedLocales) || SupportedLocales.EN
    );

    const availableCodes = availableLanguages.map(lang => lang.languageCode);

    const changeLocale = (newLocale: string) => {
        if (availableCodes.includes(newLocale)) {
            Cookies.set('locale', newLocale, {
                expires: 365,
                httpOnly: true,
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

    const cycleLocale = () => {
        const currentIndex = availableCodes.indexOf(currentLocale.value);

        const nextIndex = (currentIndex + 1) % availableCodes.length;

        const nextLocale = availableCodes[nextIndex];

        changeLocale(nextLocale);
    };

    return {
        currentLocale: currentLocale.value,
        changeLocale,
        cycleLocale
    };
}
