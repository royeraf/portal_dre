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
                // On VPS set VITE_PUBLIC_DIR=../public_html in .env
                publicDirectory: env.VITE_PUBLIC_DIR ?? 'public',
                refresh: true,
            }),
        ],
    };
});
