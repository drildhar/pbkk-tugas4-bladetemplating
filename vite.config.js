import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

/**
 * vite.config.js
 * ---------------------------------------------------------------------------
 * Titik integrasi frontend modern dengan Laravel.
 *
 *  - `input`     : dua entry point wajib -> resources/css/app.css & resources/js/app.js.
 *                  Keduanya dipanggil dari Blade via
 *                  @vite(['resources/css/app.css', 'resources/js/app.js']).
 *  - `refresh`   : Blade/route/config otomatis memicu hot-reload saat `npm run dev`.
 *  - `watch.ignored`: mencegah loop reload tiada henti akibat berkas view hasil kompilasi.
 *
 * PENTING: Tailwind di sini diproses lewat `postcss.config.js` (mode lokal / NPM).
 * Tidak ada satu pun CDN eksternal yang dipakai, sesuai ketentuan tugas.
 */
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: {
                paths: [
                    'resources/views/**',
                    'routes/**',
                    'app/**',
                    'config/**',
                ],
            },
        }),
    ],

    server: {
        host: '127.0.0.1',
        port: 5173,
        strictPort: true,
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },

    build: {
        // Hasil build masuk ke public/build dan di-referensikan otomatis oleh @vite.
        // CATATAN: JANGAN set `manifest: true` di sini. Vite akan menaruh berkasnya
        // di public/build/.vite/manifest.json, sedangkan Laravel membaca
        // public/build/manifest.json. Biarkan laravel-vite-plugin yang mengaturnya.
        outDir: 'public/build',
        emptyOutDir: true,
        sourcemap: false,
    },
});
