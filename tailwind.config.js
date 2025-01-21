import defaultTheme from 'tailwindcss/defaultTheme';
import colors from "tailwindcss/colors.js";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
        colors: {
            ...colors,
            primary: {
                DEFAULT: '#F7E2D8',
                dark: '#D6A89C'
            },
            secondary: '#383330'
        }
    },
    plugins: [],
};
