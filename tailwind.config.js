import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        "./resources/**/*.js",
    ],

    // safelist: [
    //     {
    //         pattern:/(max|min)-(w)-(sm|md|lg|xl|2xl|3xl|4xl|5xl|6xl|7xl)/,
    //         variants: ["sm", "md", "lg", "xl"],
    //     },
    // ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [
        forms,
        require('daisyui'),
    ],

    daisyui: {
        themes: ['light', 'dark']
    },

    darkMode: ['class', '[data-theme="dark"]']
};
