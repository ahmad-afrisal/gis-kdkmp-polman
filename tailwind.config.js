import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    safelist: [
        'bg-blue-500',
        'bg-blue-700',
        'bg-gray-500',
        'bg-gray-700',
        'bg-red-500',
        'bg-red-700',
        'bg-cyan-500',
        'bg-cyan-700',
        'bg-yellow-500',
        'bg-yellow-600',
        'bg-green-900',
    ],


    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
