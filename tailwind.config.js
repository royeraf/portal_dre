const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Rubik', ...defaultTheme.fontFamily.sans],
                display: ['Winky Rough', 'Rubik', ...defaultTheme.fontFamily.sans],
            },
            keyframes: {
                ticker: {
                    '0%':   { transform: 'translateX(0)' },
                    '100%': { transform: 'translateX(-50%)' },
                },
            },
            animation: {
                ticker: 'ticker 80s linear infinite',
            },
            colors: {
                dre: {
                    50:  '#e6edf8',
                    100: '#b3c8e9',
                    200: '#80a3db',
                    300: '#4d7ecc',
                    400: '#1a59be',
                    primary:  '#013072',
                    accent:   '#0069d9',
                    dark:     '#00183a',
                    darker:   '#00092b',
                },
            },
        },
    },

    plugins: [require('@tailwindcss/forms')({ strategy: 'class' })],
};
