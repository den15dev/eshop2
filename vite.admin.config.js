import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            hotFile: 'public/admin.hot',
            buildDirectory: 'admin',
            input: [
                'resources/css/admin.scss',
                'resources/js/admin.js'
            ],
            refresh: true,
        }),
    ],

    build: {
        // minify: false,
        minify: 'esbuild',
    },
});
