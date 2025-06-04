import {Language} from "@/Shared/Localization/DefaultSelectLocalization.vue";
import {SupportedLocales} from "@/i18n.config";

const languages: Language[] = [
    { languageCode: SupportedLocales.EN, languageName: 'English' },
    { languageCode: SupportedLocales.RU, languageName: 'Русский' },
    { languageCode: SupportedLocales.UK, languageName: 'Українська' },
];

export default languages;
