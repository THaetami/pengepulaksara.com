import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { ViteMinifyPlugin } from 'vite-plugin-minify'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue(),
        ViteMinifyPlugin({}),
    ],
    optimizeDeps: {
        include: ['@babel/polyfill'],
    },
    build: {
        rollupOptions: {
            external: 'NonExistingPath'
        },
        target: 'es2015',
        polyfillDynamicImport: false,
    },
    esbuild: {
        jsxFactory: 'h',
        jsxFragment: 'Fragment',
        jsxInject: `import { h } from 'vue';`,
    },
    babel: {
        presets: ['@babel/preset-env'],
        plugins: [],
    },
});
