{{--
 * resources/views/layouts/app.blade.php   ->   MASTER LAYOUT (DRY)
 * ---------------------------------------------------------------------------
 * Satu-satunya berkas yang memuat boilerplate HTML (<html>, <head>, <body>).
 * Seluruh halaman anak WAJIB memakai @extends('layouts.app') sehingga tidak
 * terjadi duplikasi struktur dokumen (aturan nomor 1 tugas).
 *
 * KONTRAK YANG DISEDIAKAN UNTUK VIEW ANAK
 *   @section('title')            -> judul tab browser (wajib diisi).
 *   @section('meta_description') -> meta description (opsional).
 *   @section('content')          -> isi utama halaman (wajib diisi).
 *   @push('styles') / @push('scripts') -> aset tambahan per halaman (opsional).
 *
 * VARIABEL YANG DIHARAPKAN DARI CONTROLLER
 *   $isDark (bool) -> Challenge 1: menambahkan kelas `dark` pada <html> sehingga
 *                     seluruh varian `dark:` Tailwind aktif.
--}}

@php
    // Nilai aman bila view anak tidak mengirim $isDark dari controller.
    $isDark = $isDark ?? false;
@endphp

<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    @class(['dark' => $isDark, 'scroll-smooth'])
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Identitas penulis dokumen, diambil dari sumber tunggal config/mahasiswa.php --}}
    <meta name="author" content="{{ $identitas['nama'] }} ({{ $identitas['nrp'] }})">
    <meta name="description" content="@yield('meta_description', 'Portal profil akademik multi-view berbasis Laravel, Blade Templating, Tailwind CSS, dan Vite.')">

    {{-- Judul dinamis: setiap halaman mengisi @section('title') --}}
    <title>@yield('title', 'Beranda') &middot; Portal Akademik {{ $identitas['nama'] }}</title>

    {{-- INTEGRASI FRONTEND MODERN: satu baris ini menggantikan semua CDN.
         Laravel otomatis menunjuk ke Vite dev server (npm run dev) atau ke
         berkas hasil build di public/build (npm run build). --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body
    class="flex min-h-screen flex-col bg-slate-50 font-sans text-slate-900 antialiased
           transition-colors duration-300
           dark:bg-slate-950 dark:text-slate-100"
>
    {{-- Aksesibilitas: tautan lompat ke konten utama untuk pengguna keyboard. --}}
    <a
        href="#konten-utama"
        class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-[60]
               focus:rounded-lg focus:bg-its-600 focus:px-4 focus:py-2 focus:text-sm
               focus:font-semibold focus:text-white"
    >
        Lewati ke konten utama
    </a>

    {{-- PARTIAL 1: navigasi (DRY - tidak ditulis ulang di setiap halaman). --}}
    @include('partials.navbar')

    {{-- Area konten yang diisi oleh view anak melalui @section('content'). --}}
    <main id="konten-utama" class="flex-1">
        @yield('content')
    </main>

    {{-- PARTIAL 2: footer institusi. --}}
    @include('partials.footer')

    @stack('scripts')
</body>
</html>
