/**
 * tailwind.config.js
 * ---------------------------------------------------------------------------
 * Konfigurasi Tailwind CSS (v3) untuk proyek PBKK Tugas Mandiri 4.
 *
 * Prinsip utama:
 *  - `content` diarahkan PRESISI hanya ke berkas yang benar-benar memuat kelas
 *    Tailwind (Blade, JS, PHP komponen, dan view paginasi vendor) agar proses
 *    build cepat dan berkas CSS produksi tetap ramping (purge/JIT optimal).
 *  - `darkMode: 'class'` dipakai untuk Challenge 1 (toggle tema dinamis) pada
 *    rute `/ide-agent?mode=dark`. Controller menambahkan kelas `dark` pada
 *    elemen <html>, lalu varian `dark:` Tailwind ikut aktif.
 *
 * @type {import('tailwindcss').Config}
 */
export default {
    darkMode: 'class',

    content: [
        // 1) Seluruh berkas Blade aplikasi (layout, partials, components, views).
        './resources/**/*.blade.php',

        // 2) Berkas JavaScript yang mungkin memuat kelas Tailwind secara dinamis.
        './resources/**/*.js',

        // 3) Komponen berbasis kelas (app/View/Components) bila ditambahkan nanti.
        './app/View/Components/**/*.php',

        // 4) View bawaan Laravel (mis. tombol paginasi) agar tidak ter-purge.
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',

        // 5) Berkas Blade yang sudah dikompilasi (jaring pengaman saat cache view).
        './storage/framework/views/*.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                mono: ['JetBrains Mono', 'ui-monospace', 'SFMono-Regular', 'monospace'],
            },
            colors: {
                // Palet identitas akademik: navy khas institusi + aksen langit.
                its: {
                    50: '#eef5ff',
                    100: '#d9e8ff',
                    200: '#bcd7ff',
                    300: '#8ebcff',
                    400: '#5996ff',
                    500: '#3370ff',
                    600: '#1c4ff5',
                    700: '#163ce1',
                    800: '#1832b6',
                    900: '#1a308f',
                    950: '#141f57',
                },
            },
            boxShadow: {
                soft: '0 10px 30px -12px rgb(15 23 42 / 0.18)',
            },
            keyframes: {
                'fade-in-up': {
                    '0%': { opacity: '0', transform: 'translateY(8px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
            },
            animation: {
                'fade-in-up': 'fade-in-up 0.35s ease-out both',
            },
        },
    },

    plugins: [],
};
