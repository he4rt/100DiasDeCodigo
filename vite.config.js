import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { local } from 'laravel-vite-plugin/fonts';
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
            fonts: [
                local('Satoshi', {
                    variants: [
                        { src: 'app-modules/he4rt/resources/fonts/satoshi/Satoshi-Light.woff2', weight: 300 },
                        { src: 'app-modules/he4rt/resources/fonts/satoshi/Satoshi-Regular.woff2', weight: 400 },
                        { src: 'app-modules/he4rt/resources/fonts/satoshi/Satoshi-Medium.woff2', weight: 500 },
                        { src: 'app-modules/he4rt/resources/fonts/satoshi/Satoshi-Bold.woff2', weight: 700 },
                    ],
                }),
                local('Fira-Code', {
                    src: 'app-modules/he4rt/resources/fonts/fira-code/FiraCode-Regular.ttf',
                }),
            ],
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
                '**/storage/framework/views/**',
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
