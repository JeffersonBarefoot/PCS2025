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
        // host: '127.0.0.1',  // Add this to force IPv4 only JLB 20250325 https://stackoverflow.com/questions/73783480/neterr-connection-refused-using-laravel-9-reactjs-with-vite-js/78344285#78344285
        port: 5173,
        watch: {
            ignored: [
                '**/vendor/**', // <----- WORKS PERFECTLY
                '**/storage/**', // <----- WORKS PERFECTLY
            ],
        },
    },
});
