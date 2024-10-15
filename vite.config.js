import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // ? WEB
                'resources/assets/scss/web/app.scss',
                'resources/assets/scss/web/swal2.scss',
                'resources/assets/scss/web/unox.scss',
                'resources/assets/js/web/app.js',
                'resources/assets/js/web/projects.js',
                'resources/assets/js/web/quotator.js',
                'resources/assets/js/web/contactor.js',
                'resources/assets/js/web/search.js',
                'resources/assets/js/web/unox-swiper.js',
                // ? DASHBOARD
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/assets/scss/dashboard/app.scss',
                'resources/assets/js/dashboard/datatables/common.js',
                'resources/assets/js/dashboard/datatables/states.js',
                'resources/assets/js/dashboard/datatables/cities.js'
            ],
            refresh: true,
        }),
    ],
});
