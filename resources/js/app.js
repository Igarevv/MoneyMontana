import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import PrimeVue from 'primevue/config';
import Aura from '@primeuix/themes/aura';
import {definePreset} from "@primeuix/themes";

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        return pages[`./Pages/${name}.vue`]
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(PrimeVue, {
                theme: {
                    preset: definePreset(Aura, {
                        semantic: {
                            primary: {
                                50: '#e8f5e9',
                                100: '#c8e6c9',
                                200: '#a5d6a7',
                                300: '#81c784',
                                400: '#66bb6a',
                                500: '#4caf50',
                                600: '#43a047',
                                700: '#388e3c',
                                800: '#2e7d32',
                                900: '#1b5e20',
                                950: '#0d4715'
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
                            info: {
                                500: '#0288d1'
                            },
                            warning: {
                                500: '#f9a825'
                            },
                            colorScheme: {
                                light: {
                                    ...Aura.semantic.colorScheme.light,
                                    primary: {
                                        color: '#4caf50',
                                        contrastColor: '#ffffff',
                                        hoverColor: '#43a047',
                                        activeColor: '#388e3c'
                                    },
                                    error: {
                                        color: '#f44336',
                                        contrastColor: '#ffffff',
                                        hoverColor: '#e53935',
                                        activeColor: '#d32f2f'
                                    },
                                    surface: {
                                        0: '#ffffff',
                                        50: '#f9fafb',
                                        100: '#f3f4f6',
                                        200: '#e5e7eb',
                                        300: '#d1d5db',
                                        400: '#9ca3af',
                                        500: '#6b7280',
                                        600: '#4b5563',
                                        700: '#374151',
                                        800: '#1f2937',
                                        900: '#111827',
                                        950: '#030712'
                                    }
                                }
                            }
                        }
                    }),
                    options: {
                        darkModeSelector: 'none',
                    },

                }
            })
            .mount(el)
    },
})