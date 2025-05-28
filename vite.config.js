import vue from '@vitejs/plugin-vue';
import {defineConfig, loadEnv} from 'vite';
import laravel from 'laravel-vite-plugin';
import collectModuleAssetsPaths from './vite-module-loader.js';
import path from 'path';
import tailwindcss from '@tailwindcss/vite'

export default async ({ mode }) => {
    process.env = {...process.env, ...loadEnv(mode, process.cwd())};

    const paths = [
        'resources/css/app.css',
        'resources/js/app.js',
    ];

    const allPaths = await collectModuleAssetsPaths(paths, 'modules');

    return defineConfig({
        plugins: [
            laravel({
                input: allPaths,
                refresh: true,
            }),
            vue(),
            tailwindcss(),
        ],
        resolve: {
            alias: {
                '@': path.resolve(__dirname, 'resources/js'),
                '@Modules': path.resolve(__dirname, 'modules'),
            },
        },
        server: {
            port: 3002,
            host: true,
            hmr: {
                host: 'localhost',
            },
        },
    });
};