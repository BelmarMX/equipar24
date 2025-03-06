import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content:    [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme:      {
        extend:     {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    safelist:   [
        {
            pattern: /bg-(red|yellow|amber|green|emerald|blue|sky|indigo|pink)-(50|100|200|300|400|500|600|700|800|900)/
        },
        {
            pattern: /text-(red|yellow|amber|green|emerald|blue|sky|indigo|pink)-(50|100|200|300|400|500|600|700|800|900)/
        },
        {
            pattern: /m-(1|2|3|4|5|6|7|8|9)/
        }
    ],

    plugins:    [forms],
    darkMode:   ['selector', '[data-mode="dark"]'],
};
