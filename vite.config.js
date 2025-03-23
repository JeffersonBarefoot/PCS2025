import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    build: {
        outDir: 'public/build',
    },
    server: { // from https://github.com/laravel/framework/discussions/46928 JLB 20250320
        port: 5173,
        watch: {
            ignored: [
                '**/vendor/**', // <----- WORKS PERFECTLY
                '**/storage/**', // <----- WORKS PERFECTLY
            ],
        },
    },
});
