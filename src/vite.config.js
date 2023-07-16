import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: true,
    },
    plugins: [
        laravel({
            input: [
                'resources/css/*',
                'resources/js/*',
            ],
            refresh: true,
        }),
    ],
});
