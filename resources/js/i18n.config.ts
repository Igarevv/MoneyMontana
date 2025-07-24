import {createI18n} from 'vue-i18n'
import en from '@/lang/i18n/en.json'
import ru from '@/lang/i18n/ru.json'
import en_panel_pages from '@/lang/i18n/en_panel_pages.json'
import ru_panel_pages from '@/lang/i18n/ru_panel_pages.json'

export enum SupportedLocales {
    EN = 'en',
    RU = 'ru',
}

export function setupI18n(locale = 'en') {
    return createI18n({
        legacy: false,
        locale,
        fallbackLocale: 'en',
        globalInjection: true,
        messages: {
            en: {
                ...en,
                panel: en_panel_pages
            },
            ru: {
                ...ru,
                panel: ru_panel_pages
            }
        },
        silentTranslationWarn: true,
        silentFallbackWarn: true,
        warnHtmlMessage: false,
    })
}