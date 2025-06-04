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
                path: '/',
                sameSite: 'Lax',
                secure: false
            });

            currentLocale.value = newLocale as SupportedLocales;

            i18nLocale.value = newLocale;

            window.location.reload();
        } else {
            console.warn(`Locale ${newLocale} is not supported.`);
        }
    };

    return {
        currentLocale: computed(() => currentLocale.value),
        changeLocale
    };
}
