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
            },
            fontFamily: {
                crimson: ['"Crimson Text"', 'serif'],
                playfair: ['"Playfair Display"', 'serif'],
            },
        },
    },
};
