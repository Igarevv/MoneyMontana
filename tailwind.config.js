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
            colors: {
                'red-orange': '#C02425',
                'yellow-orange': '#F0CB25',
                'primary-yellow': '#FFCB74',
                'primary-dark': '#111111',
                'secondary-dark': '#2F2F2F',
                'primary-white': '#F6F6F6'
            },
            fontFamily: {
                crimson: ['"Crimson Text"', 'serif'],
                playfair: ['"Playfair Display"', 'serif'],
            },
        },
    },
};
