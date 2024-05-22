import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    buildDirectory: ['build'],
    publicDir: '',
    server: { https: false, host: '127.0.0.0', },
    plugins: [
        laravel({
            input: ['resources/js/app.js','resources/css/app.css'],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});

// export default defineConfig({ buildDirectory: ['build',], plugins: [ laravel([ 'resources/css/app.css', 'resources/js/app.js', ]), ], server: { https: true, host: '0.0.0.0', }, }); 
