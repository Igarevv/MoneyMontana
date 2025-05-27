const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './modules/**/resources/**/*.{vue,js,ts,jsx,tsx}',
        './resources/js/**/*.{vue,js,ts,jsx,tsx}',
        './resources/views/**/*.blade.php',
    ],
    darkMode: 'class',
    theme: {
        extend: {

        },
    },
};
