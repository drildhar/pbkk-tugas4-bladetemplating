{{--
 * resources/views/profil.blade.php
 * ---------------------------------------------------------------------------
 * Halaman Profil Mahasiswa (rute: GET /profil-mahasiswa -> PageController@profil)
 *
 * Menampilkan profil diri lengkap (Nama, NRP, Kelas, Minat Riset) memakai
 * komponen kustom <x-info-card>. Tidak ada satu pun query/logika data di sini:
 * seluruh array ($kartuUtama, $minatRiset, $keahlian, $timeline) sudah matang
 * dari controller.
--}}

@extends('layouts.app')

@section('title', 'Profil Mahasiswa')
@section('meta_description', 'Profil akademik lengkap: nama, NRP, kelas PBKK, minat riset, keahlian, dan riwayat studi.')

@section('content')
    {{-- ==================================================================
     | 1. KEPALA HALAMAN - kartu identitas utama
     * ================================================================== --}}
    <section class="border-b border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-950">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <nav class="mb-6 text-xs text-slate-500 dark:text-slate-400" aria-label="Breadcrumb">
                <a href="{{ route('beranda') }}" class="transition hover:text-its-600 dark:hover:text-its-300">Beranda</a>
                <span class="mx-2 text-slate-300 dark:text-slate-600">/</span>
                <span class="font-medium text-slate-700 dark:text-slate-300">Profil Mahasiswa</span>
            </nav>

            <div class="flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex items-center gap-5">
                    <span class="grid h-20 w-20 shrink-0 place-items-center rounded-3xl bg-gradient-to-br from-its-600 to-sky-500 text-2xl font-black text-white shadow-soft">
                        {{ $profil['inisial'] }}
                    </span>
                    <div class="min-w-0">
                        <h1 class="text-2xl font-black tracking-tight text-slate-900 sm:text-3xl dark:text-white">
                            {{ $profil['nama'] }}
                        </h1>
                        <p class="mt-1.5 text-sm text-slate-600 dark:text-slate-400">
                            {{ $profil['program_studi'] }} &middot; {{ $profil['departemen'] }}
                        </p>
                        <div class="mt-3 flex flex-wrap gap-2">
                            <span class="badge bg-its-50 text-its-700 ring-its-200 dark:bg-its-500/10 dark:text-its-300 dark:ring-its-500/30">
                                NRP {{ $profil['nrp'] }}
                            </span>
                            <span class="badge bg-emerald-50 text-emerald-700 ring-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-300 dark:ring-emerald-500/30">
                                Kelas {{ $profil['kelas'] }}
                            </span>
                            <span class="badge bg-slate-100 text-slate-700 ring-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:ring-slate-700">
                                Angkatan {{ $profil['angkatan'] }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('ideAgent') }}" class="btn-primary">
                        <x-icon name="beaker" class="h-4 w-4" />
                        Ide Riset Kelompok
                    </a>
                    <a href="mailto:{{ $profil['email'] }}" class="btn-secondary">
                        <x-icon name="mail" class="h-4 w-4" />
                        Hubungi
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ==================================================================
     | 2. GRID KARTU IDENTITAS - komponen <x-info-card> dalam perulangan
     * ================================================================== --}}
    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white">Identitas Akademik</h2>
            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                Setiap kartu dirender oleh komponen kustom <code class="font-mono text-its-600 dark:text-its-300">&lt;x-info-card&gt;</code>.
            </p>
        </div>

        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($kartuUtama as $kartu)
                <x-info-card
                    :title="$kartu['judul']"
                    :value="$kartu['nilai']"
                    :description="$kartu['deskripsi']"
                    :icon="$kartu['ikon']"
                    :status="$kartu['status']"
                    :status-type="$kartu['statusType']"
                />
            @empty
                <x-status-banner type="warning" class="sm:col-span-2 lg:col-span-3">
                    Data identitas belum tersedia.
                </x-status-banner>
            @endforelse
        </div>
    </section>

    {{-- ==================================================================
     | 3. MINAT RISET & KEAHLIAN
     * ================================================================== --}}
    <section class="border-y border-slate-200 bg-white py-14 dark:border-slate-800 dark:bg-slate-950/40">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">
            {{-- 3a. Minat riset --}}
            <div>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white">Minat Riset</h2>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                    Tiga bidang yang menjadi fokus pengembangan diri.
                </p>

                <ul class="mt-6 space-y-5">
                    @foreach ($minatRiset as $riset)
                        <li @class([
                            'rounded-2xl border p-5 transition',
                            'border-slate-200 bg-slate-50 dark:border-slate-800 dark:bg-slate-900/60' => ! $loop->first,
                            'border-its-200 bg-its-50/60 dark:border-its-500/30 dark:bg-its-500/5' => $loop->first,
                        ])>
                            <div class="flex items-start justify-between gap-4">
                                <h3 class="text-sm font-bold text-slate-900 dark:text-white">
                                    {{ $riset['nama'] }}
                                </h3>
                                <span class="badge bg-white text-slate-600 ring-slate-200 dark:bg-slate-900 dark:text-slate-300 dark:ring-slate-700">
                                    {{ $riset['level'] }}%
                                </span>
                            </div>
                            <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                                {{ $riset['deskripsi'] }}
                            </p>

                            {{-- Bilah progres: lebar memakai gaya inline agar nilai dinamis tetap akurat. --}}
                            <div class="mt-4 h-1.5 w-full overflow-hidden rounded-full bg-slate-200 dark:bg-slate-800">
                                <div
                                    class="h-full rounded-full bg-gradient-to-r from-its-600 to-sky-400"
                                    style="width: {{ (int) $riset['level'] }}%"
                                    role="progressbar"
                                    aria-valuenow="{{ (int) $riset['level'] }}"
                                    aria-valuemin="0"
                                    aria-valuemax="100"
                                    aria-label="Tingkat penguasaan {{ $riset['nama'] }}"
                                ></div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- 3b. Keahlian teknis --}}
            <div>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white">Keahlian Teknis</h2>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                    Perkakas yang digunakan selama menempuh mata kuliah PBKK.
                </p>

                <dl class="mt-6 space-y-4">
                    @foreach ($keahlian as $skill)
                        <div>
                            <div class="flex items-center justify-between gap-4">
                                <dt class="text-sm font-medium text-slate-700 dark:text-slate-300">
                                    {{ $skill['nama'] }}
                                </dt>
                                <dd class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                                    {{ $skill['level'] }}%
                                </dd>
                            </div>
                            <div class="mt-2 h-2 w-full overflow-hidden rounded-full bg-slate-200 dark:bg-slate-800">
                                <div
                                    class="h-full rounded-full bg-its-600 dark:bg-its-500"
                                    style="width: {{ (int) $skill['level'] }}%"
                                    role="progressbar"
                                    aria-valuenow="{{ (int) $skill['level'] }}"
                                    aria-valuemin="0"
                                    aria-valuemax="100"
                                    aria-label="Tingkat keahlian {{ $skill['nama'] }}"
                                ></div>
                            </div>
                        </div>
                    @endforeach
                </dl>

                {{-- Panel informasi tambahan: menunjukkan named slot `footer` pada komponen. --}}
                <x-info-card
                    icon="clock"
                    title="Status Perkuliahan"
                    value="Semester Genap"
                    description="Sedang menempuh mata kuliah Pemrograman Berbasis Kerangka Kerja (PBKK)."
                    status="On-track"
                    status-type="success"
                    class="mt-8"
                >
                    <x-slot:footer>
                        <a href="{{ route('ideAgent') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-its-600 transition hover:text-its-700 dark:text-its-300">
                            Lihat kontribusi pada proyek kelompok
                            <x-icon name="arrow-right" class="h-3.5 w-3.5" />
                        </a>
                    </x-slot:footer>
                </x-info-card>
            </div>
        </div>
    </section>

    {{-- ==================================================================
     | 4. LINIMASA PERKULIAHAN (loop + $loop->first / $loop->last)
     * ================================================================== --}}
    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <h2 class="text-xl font-bold text-slate-900 dark:text-white">Linimasa Perkuliahan</h2>
        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
            Perjalanan akademik hingga sampai pada mata kuliah PBKK.
        </p>

        <ol class="mt-8 space-y-4 border-l-2 border-slate-200 pl-6 dark:border-slate-800">
            @forelse ($timeline as $tahap)
                <li class="relative">
                    {{-- Penanda bulat pada garis linimasa. --}}
                    <span @class([
                        'absolute -left-[31px] top-1.5 grid h-4 w-4 place-items-center rounded-full ring-4',
                        'bg-its-600 ring-its-100 dark:ring-its-500/20' => $loop->last,
                        'bg-slate-300 ring-slate-100 dark:bg-slate-700 dark:ring-slate-900' => ! $loop->last,
                    ]) aria-hidden="true"></span>

                    <div class="card-surface p-5">
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="badge bg-its-50 text-its-700 ring-its-200 dark:bg-its-500/10 dark:text-its-300 dark:ring-its-500/30">
                                {{ $tahap['periode'] }}
                            </span>

                            @if ($loop->first)
                                <span class="text-xs font-semibold text-slate-400">Awal</span>
                            @endif

                            @if ($loop->last)
                                <span class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 dark:text-emerald-400">
                                    <x-icon name="check" class="h-3.5 w-3.5" />
                                    Terkini
                                </span>
                            @endif
                        </div>

                        <h3 class="mt-3 text-sm font-bold text-slate-900 dark:text-white">
                            {{ $tahap['judul'] }}
                        </h3>
                        <p class="mt-1.5 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                            {{ $tahap['deskripsi'] }}
                        </p>
                    </div>
                </li>
            @empty
                <li class="text-sm text-slate-500 dark:text-slate-400">Linimasa belum tersedia.</li>
            @endforelse
        </ol>
    </section>
@endsection
