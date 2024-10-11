import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/assets/scss/web/app.scss',
                'resources/assets/scss/dashboard/app.scss',
                'resources/assets/css/app.css',
                'resources/assets/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
