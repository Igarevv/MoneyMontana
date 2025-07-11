import {watch} from 'vue';
import {usePage} from "@inertiajs/vue3";
import {useLocaleChange} from "@/composables/useLocaleChange";
import {useThemeToggle} from "@/composables/useThemeToggle";

export function usePreferences() {
    const page = usePage();

    const {changeLocale} = useLocaleChange();

    const {toggleByTheme} = useThemeToggle();

    watch(
        () => page.props.auth,
        (newAuth) => {
            if (newAuth !== null && page.props.logged_just_now) {
                const preferences = newAuth.preferences;

                if (preferences) {
                    changeLocale(preferences.locale);

                    toggleByTheme(preferences.theme);
                }
            }
        },
        {immediate: true}
    );

    return {
        locale: page.props.auth?.preferences?.locale ?? 'en',
        theme: page.props.auth?.preferences?.theme ?? 'light',
        currency: page.props.auth?.preferences?.currency ?? 'USD',
    };
}
