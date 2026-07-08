// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

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
                'resources/css/pages/contacts.css',
                'resources/css/pages/about.css',

                'resources/css/pages/admin/layout.css',
                'resources/css/pages/admin/products.css',
                'resources/css/pages/admin/dashboard.css',
                'resources/css/pages/admin/leads.css',
                'resources/css/pages/admin/login.css',
                'resources/css/pages/admin/categories/form.css',
                'resources/css/pages/admin/categories/index.css',

                // JS для страниц
                'resources/js/pages/home.js',
                'resources/js/pages/catalog.js',
                'resources/js/pages/product.js',
                'resources/js/pages/contacts.js',
                'resources/js/pages/about.js',

                'resources/js/pages/admin/dashboard.js',
                'resources/js/pages/admin/layout.js',
                'resources/js/pages/admin/leads.js',
                'resources/js/pages/admin/products.js',
                'resources/js/pages/admin/categories/form.js',
                'resources/js/pages/admin/categories/index.js',

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
        tailwindcss(),
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
