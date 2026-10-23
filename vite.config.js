import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/filament/admin/theme.css',
                'resources/css/filament/guest/theme.css',
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/autoAnimate.js',
                'app-modules/he4rt/resources/css/theme.css',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        cors: true,
        watch: {
            ignored: [
                '**/.agents/**',
                '**/.claude/**',
                '**/.cursor/**',
                '**/.junie/**',
                '**/storage/**',
                '**/vendor/**',
            ],
        },
    },
    build: {
        minify: 'oxc',
        cssMinify: true,
        chunkSizeWarningLimit: 1600,
        reportCompressedSize: false,
        rolldownOptions: {
            output: {
                manualChunks(id) {
                    if (id.includes('node_modules')) {
                        return id.toString().split('node_modules/')[1].split('/')[0].toString();
                    }
                },
            },
        },
    },
});
