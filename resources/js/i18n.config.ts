import { createI18n } from 'vue-i18n'
import en from '../lang/i18n/en.json'
import ru from '../lang/i18n/ru.json'
import uk from '../lang/i18n/uk.json'
import Cookies from 'js-cookie';

export enum SupportedLocales {
    EN = 'en',
    RU = 'ru',
    UK = 'uk'
}

export function setupI18n(locale = 'en') {
    return createI18n({
        legacy: false,
        locale,
        fallbackLocale: 'en',
        globalInjection: true,
        messages: { en, ru, uk },
    })
}
