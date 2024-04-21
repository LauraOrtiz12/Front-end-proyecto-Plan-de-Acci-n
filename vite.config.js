import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import Vuetify from 'vuetify';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
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
        Vuetify(),
    ],
    resolve: {
        alias: {
            '@images': '/resources/assets/images'
        }
    },
    optimizeDeps: {
        include: ['data-grid-vue'] // Asegura que DataGridVue sea incluido en el bundle
    }
});

