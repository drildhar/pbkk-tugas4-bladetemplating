/**
 * postcss.config.js
 * ---------------------------------------------------------------------------
 * Pipeline PostCSS yang dipakai Vite saat memproses `resources/css/app.css`.
 *
 *  tailwindcss  -> memindai `content` (lihat tailwind.config.js) & menyuntik utilitas.
 *  autoprefixer -> menambahkan vendor prefix (-webkit-, -moz-) sesuai browser target.
 *
 * Tanpa dua plugin ini, directive `@tailwind` di app.css tidak akan di-resolve.
 */
export default {
    plugins: {
        tailwindcss: {},
        autoprefixer: {},
    },
};
