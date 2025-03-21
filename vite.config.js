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
                'resources/assets/scss/dashboard/swal.scss',
                'resources/assets/js/dashboard/alerts.js',
                'resources/assets/js/dashboard/behavior.js',
                // ? DASHBOARD DATATABLES
                'resources/assets/js/dashboard/datatables/common.js',
                'resources/assets/js/dashboard/datatables/states.js',
                'resources/assets/js/dashboard/datatables/cities.js',
                'resources/assets/js/dashboard/datatables/form_contacts.js',
                'resources/assets/js/dashboard/datatables/banners.js',
                'resources/assets/js/dashboard/datatables/blogArticles.js',
                'resources/assets/js/dashboard/datatables/blogCategories.js',
                'resources/assets/js/dashboard/datatables/branches.js',
                'resources/assets/js/dashboard/datatables/contactList.js',
                'resources/assets/js/dashboard/datatables/contacts.js',
                'resources/assets/js/dashboard/datatables/dragger.js',
                'resources/assets/js/dashboard/datatables/productBrands.js',
                'resources/assets/js/dashboard/datatables/productCategories.js',
                'resources/assets/js/dashboard/datatables/productFreights.js',
                'resources/assets/js/dashboard/datatables/productGalleries.js',
                'resources/assets/js/dashboard/datatables/productPackages.js',
                'resources/assets/js/dashboard/datatables/productPrices.js',
                'resources/assets/js/dashboard/datatables/products.js',
                'resources/assets/js/dashboard/datatables/productSubcategories.js',
                'resources/assets/js/dashboard/datatables/projectGalleries.js',
                'resources/assets/js/dashboard/datatables/projects.js',
                'resources/assets/js/dashboard/datatables/promotionLinks.js',
                'resources/assets/js/dashboard/datatables/promotions.js',
                'resources/assets/js/dashboard/datatables/reels.js',
                'resources/assets/js/dashboard/datatables/users.js',
            ],
            refresh: true,
        }),
    ],
});
