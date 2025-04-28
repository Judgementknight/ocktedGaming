import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    build: {
        outDir: 'public/build',  // Make sure this points to the correct build folder
      },
    server: {
        port: 1222,
    },
    plugins: [
        laravel({
            input: [
            'resources/js/app.js',
            'resources/css/dash.css',
            'resources/css/auth.css',
            'resources/css/student.css',
            'resources/css/teacher.css',
            ],
            refresh: true,
        }),
    ],
});
