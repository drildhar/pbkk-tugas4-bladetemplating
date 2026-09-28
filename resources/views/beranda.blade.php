{{--
 * resources/views/beranda.blade.php
 * ---------------------------------------------------------------------------
 * Halaman Beranda (rute: GET /  ->  PageController@beranda)
 *
 * Menyambut pengguna, menampilkan ringkasan portal, dan visualisasi ringkas.
 *
 * CHALLENGE 2 (Alert Status Interaktif):
 *   Buka "/?user=Andi". Controller mengirim $namaPengguna dari query string.
 *   Blok @isset di bawah menampilkan <x-status-banner> sapaan yang menyebut
 *   nama tersebut. Bila parameter tidak ada, banner sambutan umum yang tampil.
 *
 * @extends('layouts.app')  ->  mewarisi master layout (tanpa duplikasi HTML).
--}}

@extends('layouts.app')

@section('title', 'Beranda')
@section('meta_description', 'Portal profil akademik multi-view: beranda, profil mahasiswa, dan ide riset platform Agentic AI.')

@section('content')
    {{-- ==================================================================
     | 1. HERO - sambutan utama
     * ================================================================== --}}
    <section class="relative overflow-hidden border-b border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-950">
        <div class="bg-grid-pattern absolute inset-0 opacity-60 dark:opacity-20" aria-hidden="true"></div>

        <div class="relative mx-auto grid max-w-7xl gap-12 px-4 py-16 sm:px-6 lg:grid-cols-12 lg:px-8 lg:py-24">
            <div class="lg:col-span-7">
                <span class="badge bg-its-50 text-its-700 ring-its-200 dark:bg-its-500/10 dark:text-its-300 dark:ring-its-500/30">
                    <x-icon name="sparkles" class="h-3.5 w-3.5" />
                    Tugas Mandiri 4 &middot; PBKK
                </span>

                <h1 class="mt-5 text-4xl font-black leading-tight tracking-tight text-slate-900 sm:text-5xl dark:text-white">
                    Portal Profil Akademik
                    <span class="block text-gradient">Multi-View &amp; Modular</span>
                </h1>

                <p class="mt-5 max-w-2xl text-base leading-relaxed text-slate-600 sm:text-lg dark:text-slate-400">
                    Aplikasi contoh penerapan <strong class="font-semibold text-slate-800 dark:text-slate-200">Blade Templating</strong>
                    dengan satu master layout, komponen kustom, serta integrasi
                    <strong class="font-semibold text-slate-800 dark:text-slate-200">Vite + Tailwind CSS</strong> yang dibundel
                    sepenuhnya secara lokal tanpa CDN eksternal.
                </p>

                <div class="mt-8 flex flex-wrap items-center gap-3">
                    <a href="{{ route('profilMhs') }}" class="btn-primary">
                        <x-icon name="user" class="h-4 w-4" />
                        Lihat Profil Mahasiswa
                    </a>
                    <a href="{{ route('ideAgent') }}" class="btn-secondary">
                        <x-icon name="beaker" class="h-4 w-4" />
                        Jelajahi Ide Riset Agent
                    </a>
                </div>
            </div>

            {{-- Kartu identitas ringkas di sisi kanan hero --}}
            <div class="lg:col-span-5">
                <div class="card-surface p-6 shadow-soft">
                    <div class="flex items-center gap-4">
                        <span class="grid h-14 w-14 shrink-0 place-items-center rounded-2xl bg-gradient-to-br from-its-600 to-sky-500 text-lg font-black text-white">
                            {{ $profil['inisial'] }}
                        </span>
                        <div class="min-w-0">
                            <p class="truncate text-base font-bold text-slate-900 dark:text-white">
                                {{ $profil['nama'] }}
                            </p>
                            <p class="text-sm text-slate-500 dark:text-slate-400">
                                {{ $profil['nrp'] }} &middot; {{ $profil['kelas'] }}
                            </p>
                        </div>
                    </div>

                    <dl class="mt-6 space-y-3 border-t border-slate-100 pt-5 text-sm dark:border-slate-800">
                        <div class="flex items-start justify-between gap-4">
                            <dt class="text-slate-500 dark:text-slate-400">Program Studi</dt>
                            <dd class="text-right font-medium text-slate-800 dark:text-slate-200">{{ $profil['program_studi'] }}</dd>
                        </div>
                        <div class="flex items-start justify-between gap-4">
                            <dt class="text-slate-500 dark:text-slate-400">Departemen</dt>
                            <dd class="text-right font-medium text-slate-800 dark:text-slate-200">{{ $profil['departemen'] }}</dd>
                        </div>
                        <div class="flex items-start justify-between gap-4">
                            <dt class="text-slate-500 dark:text-slate-400">Angkatan</dt>
                            <dd class="text-right font-medium text-slate-800 dark:text-slate-200">{{ $profil['angkatan'] }}</dd>
                        </div>
                    </dl>

                    <p class="mt-5 rounded-xl bg-slate-50 px-4 py-3 text-xs leading-relaxed text-slate-500 dark:bg-slate-950/60 dark:text-slate-400">
                        Identitas ini bersumber dari satu berkas konfigurasi
                        (<code class="font-mono text-its-600 dark:text-its-300">config/mahasiswa.php</code>),
                        bukan di-hardcode di setiap view.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- ==================================================================
     | 2. CHALLENGE 2 - Alert status interaktif berbasis query string
     |    Contoh: /?user=Andi  atau  /beranda?user=Rina
     * ================================================================== --}}
    <section class="mx-auto max-w-7xl px-4 pt-10 sm:px-6 lg:px-8">
        @isset($namaPengguna)
            {{-- Parameter `user` ADA -> sapaan personal + tombol tutup. --}}
            <x-status-banner
                type="success"
                :title="'Selamat datang kembali, ' . $namaPengguna . '!'"
                dismissible
                :autodismiss="8000"
            >
                Senang melihat Anda lagi di portal profil akademik.
                Tema dan navigasi tetap dapat Anda ubah kapan saja dari bilah atas.
            </x-status-banner>
        @else
            {{-- Parameter `user` TIDAK ADA -> banner sambutan umum. --}}
            <x-status-banner type="info" title="Selamat datang di Portal Profil Akademik">
                Anda membuka halaman ini tanpa parameter <code class="font-mono">user</code>.
                Coba jalankan
                <a href="{{ route('beranda', ['user' => 'Andi']) }}" class="font-semibold underline underline-offset-2">
                    {{ route('beranda', ['user' => 'Andi']) }}
                </a>
                untuk melihat sapaan dinamis (Challenge 2).
            </x-status-banner>
        @endisset
    </section>

    {{-- ==================================================================
     | 3. STATISTIK RINGKAS - visualisasi ringkas portal
     * ================================================================== --}}
    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="mb-6 flex items-end justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white">Ringkasan Portal</h2>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                    Dipetakan langsung dari struktur rute, komponen, dan pipeline aset.
                </p>
            </div>
            <span class="hidden text-xs font-medium text-slate-400 sm:block">
                <code class="font-mono">PageController@beranda</code>
            </span>
        </div>

        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @forelse ($statistik as $item)
                <x-info-card
                    :title="$item['label']"
                    :value="$item['nilai']"
                    :description="$item['deskripsi']"
                    :icon="$item['ikon']"
                    :status="$item['satuan']"
                    status-type="neutral"
                />
            @empty
                <x-status-banner type="warning" class="sm:col-span-2 lg:col-span-4">
                    Data statistik belum tersedia dari controller.
                </x-status-banner>
            @endforelse
        </div>
    </section>

    {{-- ==================================================================
     | 4. FITUR UNGGULAN
     * ================================================================== --}}
    <section class="border-y border-slate-200 bg-white py-14 dark:border-slate-800 dark:bg-slate-950/40">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl">
                <h2 class="text-xl font-bold text-slate-900 dark:text-white">Fitur Unggulan Implementasi</h2>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                    Empat pilar teknis yang dipenuhi pada tugas ini.
                </p>
            </div>

            <div class="mt-8 grid gap-5 sm:grid-cols-2">
                @foreach ($fiturUnggulan as $fitur)
                    <x-info-card
                        :title="$fitur['judul']"
                        :description="$fitur['deskripsi']"
                        :icon="$fitur['ikon']"
                    >
                        <x-slot:footer>
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-its-600 dark:text-its-300">
                                <x-icon name="check" class="h-3.5 w-3.5" />
                                Terimplementasi
                            </span>
                        </x-slot:footer>
                    </x-info-card>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ==================================================================
     | 5. ALUR KERJA REQUEST -> RESPONSE (loop dengan metadata $loop)
     * ================================================================== --}}
    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <h2 class="text-xl font-bold text-slate-900 dark:text-white">Alur Kerja Aplikasi</h2>
        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
            Dari permintaan HTTP hingga aset frontend tersaji.
        </p>

        <ol class="mt-8 grid gap-5 md:grid-cols-4">
            @foreach ($alurKerja as $langkah)
                <li @class([
                    'card-surface relative p-5',
                    'ring-1 ring-its-200 dark:ring-its-500/30' => $loop->first,
                ])>
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-its-600 text-sm font-bold text-white">
                        {{ $loop->iteration }}
                    </span>
                    <p class="mt-3 text-sm font-semibold leading-relaxed text-slate-800 dark:text-slate-200">
                        {{ $langkah }}
                    </p>

                    @if ($loop->last)
                        <span class="mt-3 inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 dark:text-emerald-400">
                            <x-icon name="check" class="h-3.5 w-3.5" />
                            Selesai
                        </span>
                    @endif
                </li>
            @endforeach
        </ol>
    </section>
@endsection
