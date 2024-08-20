import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: '0.0.0.0',
        hmr: {
            host: 'localhost'
        },
    },

    plugins: [
        laravel({
            hotFile: 'public/site.hot',
            input: [
                'resources/css/app.scss',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],

    build: {
        // minify: false,
        minify: 'esbuild',
    },
});
