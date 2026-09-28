{{--
 * resources/views/partials/footer.blade.php
 * ---------------------------------------------------------------------------
 * PARTIAL FOOTER (dipanggil via @include('partials.footer') dari master layout).
 *
 * Menampilkan identitas institusi, ringkasan tugas, dan hak cipta dengan tahun
 * yang dihitung dinamis memakai blok PHP dan helper date('Y').
--}}

@php
    $tahunSekarang = date('Y');

    // $identitas dibagikan global oleh AppServiceProvider::boot() (View::share).
    $tautanFooter = [
        ['label' => 'Beranda', 'rute' => 'beranda'],
        ['label' => 'Profil Mahasiswa', 'rute' => 'profilMhs'],
        ['label' => 'Ide Riset Agent', 'rute' => 'ideAgent'],
    ];

    $teknologiFooter = ['Laravel', 'Blade Templating', 'Tailwind CSS', 'Vite'];
@endphp

<footer class="mt-16 border-t border-slate-200 bg-white transition-colors duration-300 dark:border-slate-800 dark:bg-slate-950">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid gap-10 md:grid-cols-12">
            {{-- Kolom 1: Identitas institusi --}}
            <div class="md:col-span-5">
                <div class="flex items-center gap-3">
                    <span class="grid h-10 w-10 place-items-center rounded-xl bg-gradient-to-br from-its-600 to-sky-500 text-xs font-black text-white">
                        ITS
                    </span>
                    <p class="text-sm font-bold text-slate-900 dark:text-white">
                        {{ $identitas['institusi'] }}
                    </p>
                </div>
                <p class="mt-4 max-w-md text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                    {{ $identitas['departemen'] }} &mdash; {{ $identitas['fakultas'] }}.
                    Portal ini disusun sebagai pemenuhan Tugas Mandiri 4 mata kuliah
                    Pemrograman Berbasis Kerangka Kerja (PBKK).
                </p>
                <p class="mt-3 inline-flex items-center gap-1.5 text-sm text-slate-500 dark:text-slate-400">
                    <x-icon name="pin" class="h-4 w-4" />
                    {{ $identitas['lokasi'] }}
                </p>
            </div>

            {{-- Kolom 2: Navigasi cepat --}}
            <div class="md:col-span-3">
                <h2 class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                    Navigasi
                </h2>
                <ul class="mt-4 space-y-2.5">
                    @foreach ($tautanFooter as $tautan)
                        <li>
                            <a
                                href="{{ route($tautan['rute']) }}"
                                class="inline-flex items-center gap-1.5 text-sm text-slate-600 transition hover:text-its-600 dark:text-slate-400 dark:hover:text-its-300"
                            >
                                <x-icon name="arrow-right" class="h-3.5 w-3.5" />
                                {{ $tautan['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Kolom 3: Teknologi & identitas penulis --}}
            <div class="md:col-span-4">
                <h2 class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                    Dibangun Dengan
                </h2>
                <div class="mt-4 flex flex-wrap gap-2">
                    @foreach ($teknologiFooter as $teknologi)
                        <span class="badge bg-slate-100 text-slate-700 ring-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:ring-slate-700">
                            {{ $teknologi }}
                        </span>
                    @endforeach
                </div>

                <dl class="mt-5 space-y-1.5 text-sm">
                    <div class="flex gap-2">
                        <dt class="w-16 shrink-0 text-slate-500 dark:text-slate-400">Nama</dt>
                        <dd class="font-medium text-slate-800 dark:text-slate-200">
                            {{ $identitas['nama'] }}
                        </dd>
                    </div>
                    <div class="flex gap-2">
                        <dt class="w-16 shrink-0 text-slate-500 dark:text-slate-400">NRP</dt>
                        <dd class="font-medium text-slate-800 dark:text-slate-200">
                            {{ $identitas['nrp'] }}
                        </dd>
                    </div>
                    <div class="flex gap-2">
                        <dt class="w-16 shrink-0 text-slate-500 dark:text-slate-400">Kelas</dt>
                        <dd class="font-medium text-slate-800 dark:text-slate-200">
                            {{ $identitas['kelas'] }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        {{-- Hak cipta: tahun dihitung otomatis dari sisi server. --}}
        <div class="mt-10 flex flex-col gap-2 border-t border-slate-200 pt-6 text-xs text-slate-500 sm:flex-row sm:items-center sm:justify-between dark:border-slate-800 dark:text-slate-400">
            <p>
                &copy; {{ $tahunSekarang }} {{ $identitas['institusi'] }}. Seluruh hak cipta dilindungi.
            </p>
            <p>
                Tugas Mandiri 4 PBKK &middot; Blade Templating &amp; Integrasi Frontend Modern
            </p>
        </div>
    </div>
</footer>
