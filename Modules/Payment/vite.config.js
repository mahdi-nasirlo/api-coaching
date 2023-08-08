const dotenvExpand = require('dotenv-expand');
<<<<<<< HEAD
dotenvExpand(require('dotenv').config({path: '../../.env'/*, debug: true*/}));

import {defineConfig} from 'vite';
=======
dotenvExpand(require('dotenv').config({ path: '../../.env'/*, debug: true*/}));

import { defineConfig } from 'vite';
>>>>>>> origin/module/payment
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    build: {
        outDir: '../../public/build-payment',
        emptyOutDir: true,
        manifest: true,
    },
    plugins: [
        laravel({
            publicDirectory: '../../public',
            buildDirectory: 'build-payment',
            input: [
                __dirname + '/Resources/assets/sass/app.scss',
                __dirname + '/Resources/assets/js/app.js'
            ],
            refresh: true,
        }),
    ],
});
