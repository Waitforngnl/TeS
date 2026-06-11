import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/css/auth-styles.css',
                'resources/js/auth-scripts.js',
                'resources/css/navbar.css',
                'resources/css/product.css',
                'resources/js/product.js',
                'resources/css/cart.css',
                'resources/js/cart.js',
                'resources/css/history.css',
                'resources/js/history.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
