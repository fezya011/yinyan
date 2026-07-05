// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',

                // CSS для страниц
                'resources/css/pages/home.css',
                'resources/css/pages/catalog.css',
                'resources/css/pages/product.css',


                // JS для страниц
                'resources/js/pages/home.js',
                'resources/js/pages/catalog.js',
                'resources/js/pages/product.js',

                // CSS для компонентов
                'resources/css/partials/header.css',
                'resources/css/partials/footer.css',
                'resources/css/partials/lead-modal.css',

                // JS для компонентов
                'resources/js/partials/header.js',
                'resources/js/partials/footer.js',
                'resources/js/partials/lead-modal.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0',
        port: 5173,
        https: false,
        hmr: {
            host: 'localhost',
        },
    },
});
