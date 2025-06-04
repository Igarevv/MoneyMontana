import {createInertiaApp} from '@inertiajs/vue3';
import createServer from '@inertiajs/vue3/server';
import {renderToString} from '@vue/server-renderer';
import {createSSRApp, h} from 'vue';
import {setupI18n} from "./i18n.config.ts";
import PrimeVue from "primevue/config";
import {definePreset} from "@primeuix/themes";
import Aura from "@primeuix/themes/aura";

createServer(page =>
    createInertiaApp({
        page,
        render: renderToString,
        resolve: name => {
            const pages = import.meta.glob('./Pages/**/*.vue', {eager: true});
            return pages[`./Pages/${name}.vue`];
        },
        setup({App, props, plugin}) {
            const i18n = setupI18n(props.locale || 'en');

            const app = createSSRApp({
                render: () => h(App, props),
            });

            app.use(i18n);

            app.use(plugin);

            app.use(PrimeVue, {
                theme: {
                    preset: definePreset(Aura, {
                        semantic: {
                            primary: {
                                100: '#FFF3E1',
                                200: '#FFE1B8',
                                300: '#FFD190',
                                400: '#FFC178',
                                500: '#FFCB74',
                                600: '#F0B260',
                                700: '#D99949',
                                800: '#B77C35',
                                900: '#8F5B23'
                            },
                            error: {
                                50: '#ffebee',
                                100: '#ffcdd2',
                                200: '#ef9a9a',
                                300: '#e57373',
                                400: '#ef5350',
                                500: '#f44336',
                                600: '#e53935',
                                700: '#d32f2f',
                                800: '#c62828',
                                900: '#b71c1c',
                                950: '#7f1212'
                            },
                            surface: {
                                0: '#ffffff',
                                50: '#F6F6F6',
                                100: '#F6F6F6',
                                200: '#F6F6F6',
                                300: '#F6F6F6',
                                400: '#2F2F2F',
                                500: '#2F2F2F',
                                600: '#111111',
                                700: '#111111',
                                800: '#111111',
                                900: '#111111',
                                950: '#111111'
                            },
                            info: {
                                500: '#0288d1'
                            },
                            warning: {
                                500: '#f9a825'
                            },
                            colorScheme: {
                                light: {
                                    ...Aura.semantic.colorScheme.light,
                                    error: {
                                        color: '#f44336',
                                        contrastColor: '#ffffff',
                                        hoverColor: '#e53935',
                                        activeColor: '#d32f2f'
                                    },
                                    primary: {
                                        color: '#FFCB74',
                                        contrastColor: '#111111',
                                        hoverColor: '#e6b060',
                                        activeColor: '#cc9c52'
                                    },
                                    surface: {
                                        0: '#ffffff',
                                        50: '#F6F6F6',
                                        100: '#F6F6F6',
                                        200: '#F6F6F6',
                                        300: '#F6F6F6',
                                        400: '#2F2F2F',
                                        500: '#2F2F2F',
                                        600: '#111111',
                                        700: '#111111',
                                        800: '#111111',
                                        900: '#111111',
                                        950: '#111111'
                                    }
                                }
                            }
                        }
                    }),
                    options: {
                        darkModeSelector: '.dark',
                    },
                }
            });

            return app;
        },
    }),
);