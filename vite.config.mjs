import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig(({ mode }) => {
    const env = loadEnv(mode, process.cwd(), '');

    return {
        plugins: [
            laravel({
                input: [
                    'resources/css/app.css',
                    'resources/js/app.js',
                ],
                // En el VPS se puede definir VITE_PUBLIC_DIR=../public_html.
                publicDirectory: env.VITE_PUBLIC_DIR ?? 'public',
                refresh: true,
            }),
        ],
    };
});
