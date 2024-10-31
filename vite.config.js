import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import {globSync} from 'glob'
const files = globSync([
    './resources/js/pages/**/*.js',
    './resources/js/vendor/**/*.js',
]);

export default defineConfig({
    plugins: [
        laravel({
            input: [
                ...files,
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/login.css',
            ],
            refresh: true,
        }),
    ],
});
