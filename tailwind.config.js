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
            pattern: /bg-(red|yellow|amber|green|emerald|blue|sky)-(50|100|200|300|400|500|600|700|800|900)/
        },
        {
            pattern: /text-(red|yellow|amber|green|emerald|blue)-(50|100|200|300|400|500|600|700|800|900)/
        }
    ],

    plugins:    [forms],
    darkMode:   ['selector', '[data-mode="dark"]'],
};
