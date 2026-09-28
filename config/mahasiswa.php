<?php

/**
 * config/mahasiswa.php
 * ---------------------------------------------------------------------------
 * SUMBER TUNGGAL IDENTITAS MAHASISWA (Single Source of Truth).
 *
 * Ganti nilai placeholder di bawah ini SATU KALI SAJA, lalu seluruh halaman
 * (Beranda, Profil, Navbar, Footer) otomatis ikut berubah. Pendekatan ini
 * adalah wujud prinsip DRY pada lapisan data.
 *
 * Cari string berikut untuk mengganti identitas:
 *   [NAMA_LENGKAP_MAHASISWA], [NRP_MAHASISWA], [KELAS_PBKK]
 *
 * Nilai dapat dioverride lewat berkas `.env` tanpa mengubah kode ini.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Identitas Utama
    |--------------------------------------------------------------------------
    */
    'nama' => env('MAHASISWA_NAMA', '[NAMA_LENGKAP_MAHASISWA]'),
    'nrp' => env('MAHASISWA_NRP', '[NRP_MAHASISWA]'),
    'kelas' => env('MAHASISWA_KELAS', '[KELAS_PBKK]'),

    /*
    |--------------------------------------------------------------------------
    | Identitas Akademik
    |--------------------------------------------------------------------------
    */
    'departemen' => env('MAHASISWA_DEPARTEMEN', 'Departemen Teknik Informatika'),
    'fakultas' => env('MAHASISWA_FAKULTAS', 'Fakultas Teknologi Elektro dan Informatika Cerdas (FTEIC)'),
    'institusi' => env('MAHASISWA_INSTITUSI', 'Institut Teknologi Sepuluh Nopember (ITS)'),
    'program_studi' => env('MAHASISWA_PRODI', 'S1 Teknik Informatika'),
    'angkatan' => env('MAHASISWA_ANGKATAN', '20XX'),
    'email' => env('MAHASISWA_EMAIL', 'nrp@mhs.its.ac.id'),
    'lokasi' => env('MAHASISWA_LOKASI', 'Surabaya, Jawa Timur, Indonesia'),

    /*
    |--------------------------------------------------------------------------
    | Profil Riset
    |--------------------------------------------------------------------------
    | Dipakai halaman Profil & Ide Riset (array multidimensi).
    */
    'minat_riset' => [
        [
            'nama' => 'Agentic AI & LLM Orchestration',
            'deskripsi' => 'Perancangan agen otonom yang mampu merencanakan, memanggil tool, dan mengevaluasi hasil secara mandiri.',
            'level' => 90,
        ],
        [
            'nama' => 'Human-Computer Interaction',
            'deskripsi' => 'Perancangan antarmuka desktop/web yang adaptif dan aksesibel untuk alur kerja berbasis agen.',
            'level' => 80,
        ],
        [
            'nama' => 'Rekayasa Perangkat Lunak Berbasis Kerangka Kerja',
            'deskripsi' => 'Penerapan arsitektur MVC, pengujian otomatis, dan integrasi pipeline frontend modern.',
            'level' => 85,
        ],
    ],

    'keahlian' => [
        ['nama' => 'PHP / Laravel', 'level' => 88],
        ['nama' => 'Blade Templating', 'level' => 92],
        ['nama' => 'Tailwind CSS & Vite', 'level' => 85],
        ['nama' => 'JavaScript (ES2024)', 'level' => 78],
        ['nama' => 'Python & LLM Stack', 'level' => 80],
    ],
];
