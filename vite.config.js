import vue from '@vitejs/plugin-vue';
import {defineConfig, loadEnv} from 'vite';
import laravel from 'laravel-vite-plugin';
import collectModuleAssetsPaths from './vite-module-loader.js';
import path from 'path';

export default async ({ mode }) => {
    process.env = {...process.env, ...loadEnv(mode, process.cwd())};

    const paths = [
        'resources/css/app.css',
        'resources/js/app.js',
    ];

    const allPaths = await collectModuleAssetsPaths(paths, 'modules');

    return defineConfig({
        base: process.env.APP_ENV === 'production' ? '/build/' : undefined,
        plugins: [
            laravel({
                input: allPaths,
                ssr: 'resources/js/ssr.js',
                refresh: true,
                publicPath: "/public/",
            }),
            vue(),
        ],
        resolve: {
            alias: {
                '@': path.resolve(__dirname, 'resources/js'),
                '@Modules': path.resolve(__dirname, 'modules'),
            },
        },
        build: {
            outDir: 'public/build',
            assetsDir: 'assets',
            manifest: true,
            rollupOptions: {
                input: '/resources/js/app.js'
            }
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