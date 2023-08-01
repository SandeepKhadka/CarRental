import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
const path = require('path');

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/css/admin.css',
                'resources/js/admin.js',
                'resources/css/frontend.css',
                'resources/js/frontend.js',
            ],
            refresh: true,
        }),
    ],

    resolve :{
        alias :{
            '~bootstrap' : path.resolve(__dirname, 'node_modules/bootstrap')
        }
    }
});
