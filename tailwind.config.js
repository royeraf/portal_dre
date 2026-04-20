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

    safelist: [
        // convocatorias.blade.php — $tipoStyles dynamic pill/bar/bg/border
        'bg-blue-50',   'bg-blue-100',   'bg-blue-500',   'text-blue-700',   'border-blue-100',
        'bg-indigo-50', 'bg-indigo-100', 'bg-indigo-500', 'text-indigo-700', 'border-indigo-100',
        'bg-emerald-50','bg-emerald-100','bg-emerald-500','text-emerald-700','border-emerald-100',
        'bg-emerald-200','border-emerald-200','hover:bg-emerald-600','shadow-emerald-200',
        'bg-teal-50',   'bg-teal-100',   'bg-teal-500',   'text-teal-700',   'border-teal-100',
        'bg-orange-50', 'bg-orange-100', 'bg-orange-500', 'text-orange-700', 'border-orange-100',
        'bg-purple-50', 'bg-purple-100', 'bg-purple-500', 'text-purple-700', 'border-purple-100',
        // popup close button
        'bg-red-600', 'hover:bg-red-500', 'active:bg-red-700',
        // directorio.blade.php — $directivos dynamic bar/ring
        'bg-indigo-600', 'ring-indigo-400',
        'bg-teal-600',   'ring-teal-400',
        'bg-purple-600', 'ring-purple-400',
        'bg-amber-600',  'ring-amber-400',
    ],

    plugins: [require('@tailwindcss/forms')({ strategy: 'class' })],
};
