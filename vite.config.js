import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/jquery-3.7.1.min.js',
            ],
            refresh: true,
        }),
    ],
    build: {
        // SwiperライブラリのJavaScriptファイルをエントリーポイントとして指定
        rollupOptions: {
            input: {
                main: './resources/js/main.js', // 既存のエントリーポイントを指定
                swiper: './node_modules/swiper/swiper-bundle.js', // Swiper のパスを指定
            },
        },
    },
    // ロゴ表示崩れ対策
    server: {
        hmr: {
            host: 'localhost',
        },
    },
});
