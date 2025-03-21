import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    build: {
        outDir: 'public/build',
    },
    server: { // from https://github.com/laravel/framework/discussions/46928 JLB 20250320
        watch: {
            ignored: [
                '**/vendor/**', // <----- WORKS PERFECTLY
                '**/storage/**', // <----- WORKS PERFECTLY
            ],
        },
    },
});
