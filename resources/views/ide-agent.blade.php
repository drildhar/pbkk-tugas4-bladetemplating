{{--
 * resources/views/ide-agent.blade.php
 * ---------------------------------------------------------------------------
 * Halaman Ide Riset (rute: GET /ide-agent -> PageController@ideAgent)
 *
 *  CHALLENGE 1 - Toggle Tema Dinamis
 *    Buka "/ide-agent?mode=dark". Controller menangkap parameter `mode` dan
 *    mengirim $isDark = true. Master layout menambahkan kelas `dark` pada
 *    <html> sehingga SELURUH varian `dark:` Tailwind pada halaman ini aktif.
 *    Tautan toggle di navbar membalik nilai tersebut (?mode=light / ?mode=dark).
 *
 *  TABEL FITUR KELOMPOK
 *    Dirender dengan @forelse memakai metadata sakti $loop:
 *    $loop->iteration, $loop->index, $loop->first, $loop->last,
 *    $loop->even / $loop->odd, $loop->count, $loop->remaining.
 *
 *  FORMULIR PENGUMPULAN IDE
 *    <form method="POST"> + @csrf. Hasil validasi dari PageController@simpanIde
 *    dikirim balik sebagai flash message dan dirender <x-status-banner>.
--}}

@extends('layouts.app')

@section('title', 'Ide Riset Agent')
@section('meta_description', 'Ide platform Agentic AI Desktop/Web kelompok: arsitektur, tabel fitur dan tugas, milestone, serta formulir pengumpulan ide.')

@section('content')
    {{-- ==================================================================
     | 1. KEPALA HALAMAN - Challenge 1 (indikator tema aktif)
     * ================================================================== --}}
    <section @class([
        'border-b transition-colors duration-300',
        'border-slate-800 bg-slate-950' => $isDark,
        'border-slate-200 bg-white' => ! $isDark,
    ])>
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <nav class="mb-6 text-xs" aria-label="Breadcrumb">
                <a href="{{ route('beranda') }}" class="text-slate-500 transition hover:text-its-600 dark:text-slate-400 dark:hover:text-its-300">Beranda</a>
                <span class="mx-2 text-slate-300 dark:text-slate-600">/</span>
                <span class="font-medium text-slate-700 dark:text-slate-300">Ide Riset Agent</span>
            </nav>

            <div class="flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-3xl">
                    {{-- Kelas berikut dihitung dinamis dari $isDark (Challenge 1). --}}
                    <span @class([
                        'badge',
                        'bg-its-500/10 text-its-300 ring-its-500/30' => $isDark,
                        'bg-its-50 text-its-700 ring-its-200' => ! $isDark,
                    ])>
                        <x-icon name="sparkles" class="h-3.5 w-3.5" />
                        Ide Platform Kelompok
                    </span>

                    <h1 class="mt-5 text-3xl font-black leading-tight tracking-tight text-slate-900 sm:text-4xl dark:text-white">
                        {{ $proyek['nama'] }}
                    </h1>

                    <p class="mt-3 text-base font-medium text-its-600 dark:text-its-300">
                        {{ $proyek['tagline'] }}
                    </p>

                    <p class="mt-5 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                        {{ $proyek['deskripsi'] }}
                    </p>
                </div>

                <div class="shrink-0">
                    <div class="card-surface p-5">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                            Tema Aktif
                        </p>
                        <p class="mt-1.5 flex items-center gap-2 text-sm font-bold text-slate-900 dark:text-white">
                            <x-icon :name="$isDark ? 'moon' : 'sun'" class="h-4 w-4" />
                            {{ $isDark ? 'Gelap (mode=dark)' : 'Terang (default)' }}
                        </p>
                        <p class="mt-3 text-xs leading-relaxed text-slate-500 dark:text-slate-400">
                            Uji Challenge 1:
                            <a href="{{ route('ideAgent', ['mode' => 'dark']) }}" class="font-semibold underline underline-offset-2">?mode=dark</a>
                            &middot;
                            <a href="{{ route('ideAgent', ['mode' => 'light']) }}" class="font-semibold underline underline-offset-2">?mode=light</a>
                        </p>
                    </div>
                </div>
            </div>

            {{-- Metrik proyek hasil loop dari controller --}}
            <dl class="mt-8 grid gap-4 sm:grid-cols-3">
                @foreach ($proyek['metrik'] as $metrik)
                    <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 dark:border-slate-800 dark:bg-slate-900/60">
                        <dt class="text-xs font-medium uppercase tracking-wide text-slate-500 dark:text-slate-400">
                            {{ $metrik['label'] }}
                        </dt>
                        <dd class="mt-1 text-sm font-bold text-slate-900 dark:text-white">
                            {{ $metrik['nilai'] }}
                        </dd>
                    </div>
                @endforeach
            </dl>
        </div>
    </section>

    {{-- ==================================================================
     | 2. NOTIFIKASI: flash message formulir + galat validasi
     * ================================================================== --}}
    <section class="mx-auto max-w-7xl space-y-4 px-4 pt-8 sm:px-6 lg:px-8">
        @if (session()->has('status'))
            @php $notifikasi = session('status'); @endphp
            <x-status-banner
                :type="$notifikasi['type']"
                :title="$notifikasi['title']"
                dismissible
                :autodismiss="10000"
            >
                {{ $notifikasi['message'] }}
            </x-status-banner>
        @endif

        @if ($errors->any())
            <x-status-banner type="danger" title="Periksa kembali isian formulir Anda" dismissible>
                <ul class="mt-1 list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $galat)
                        <li>{{ $galat }}</li>
                    @endforeach
                </ul>
            </x-status-banner>
        @endif
    </section>

    {{-- ==================================================================
     | 3. ARSITEKTUR PLATFORM
     * ================================================================== --}}
    <section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <h2 class="text-xl font-bold text-slate-900 dark:text-white">Arsitektur Platform</h2>
        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
            Pembagian lapisan beserta teknologi dan tanggung jawabnya.
        </p>

        <div class="card-surface mt-6 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm dark:divide-slate-800">
                    <caption class="sr-only">Arsitektur platform NARA</caption>
                    <thead class="bg-slate-50 dark:bg-slate-900/60">
                        <tr>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Lapisan</th>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Teknologi</th>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Tanggung Jawab</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($proyek['arsitektur'] as $lapisan)
                            <tr @class([
                                'transition hover:bg-slate-50 dark:hover:bg-slate-800/40',
                                'bg-white dark:bg-slate-900' => $loop->odd,
                                'bg-slate-50/60 dark:bg-slate-900/40' => $loop->even,
                            ])>
                                <td class="whitespace-nowrap px-5 py-3.5 font-semibold text-slate-900 dark:text-white">
                                    {{ $lapisan['lapisan'] }}
                                </td>
                                <td class="px-5 py-3.5 text-its-600 dark:text-its-300">
                                    {{ $lapisan['teknologi'] }}
                                </td>
                                <td class="px-5 py-3.5 text-slate-600 dark:text-slate-400">
                                    {{ $lapisan['fungsi'] }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- ==================================================================
     | 4. TABEL FITUR & PEMBAGIAN TUGAS KELOMPOK
     |    Inti demonstrasi @forelse + metadata $loop
     * ================================================================== --}}
    <section class="border-y border-slate-200 bg-white py-12 dark:border-slate-800 dark:bg-slate-950/40">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white">Fitur &amp; Pembagian Tugas Kelompok</h2>
                    <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                        Dirender dengan <code class="font-mono text-its-600 dark:text-its-300">@@forelse</code>
                        dan metadata <code class="font-mono text-its-600 dark:text-its-300">$loop</code>.
                    </p>
                </div>

                {{-- Ringkasan memanfaatkan $loop->count pada baris pertama. --}}
                <p class="text-xs font-medium text-slate-500 dark:text-slate-400">
                    Total <span class="font-bold text-slate-800 dark:text-slate-200">{{ $jumlahFitur }}</span> pekerjaan aktif
                </p>
            </div>

            <div class="card-surface mt-6 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm dark:divide-slate-800">
                        <caption class="sr-only">Daftar fitur dan penanggung jawab</caption>
                        <thead class="bg-slate-50 dark:bg-slate-900/60">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">No</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Fitur / Tugas</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Modul</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Penanggung Jawab</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Status</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Progres</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse ($fitur as $pekerjaan)
                                <tr @class([
                                    'transition hover:bg-its-50/60 dark:hover:bg-its-500/5',
                                    'bg-white dark:bg-slate-900' => $loop->odd,
                                    'bg-slate-50/60 dark:bg-slate-900/40' => $loop->even,
                                ])>
                                    {{-- $loop->iteration: nomor urut mulai dari 1 --}}
                                    <td class="whitespace-nowrap px-4 py-4 align-top">
                                        <span @class([
                                            'inline-flex h-6 w-6 items-center justify-center rounded-lg text-xs font-bold',
                                            'bg-its-600 text-white' => $loop->first,
                                            'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300' => ! $loop->first,
                                        ])>
                                            {{ $loop->iteration }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-4 align-top">
                                        <p class="font-semibold text-slate-900 dark:text-white">
                                            {{ $pekerjaan['nama'] }}
                                        </p>
                                        <p class="mt-1 flex flex-wrap items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
                                            <span>Prioritas: {{ $pekerjaan['prioritas'] }}</span>

                                            {{-- $loop->first / $loop->last menandai ujung daftar --}}
                                            @if ($loop->first)
                                                <span class="badge bg-emerald-50 text-emerald-700 ring-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-300 dark:ring-emerald-500/30">
                                                    Item pertama
                                                </span>
                                            @endif

                                            @if ($loop->last)
                                                <span class="badge bg-amber-50 text-amber-700 ring-amber-200 dark:bg-amber-500/10 dark:text-amber-300 dark:ring-amber-500/30">
                                                    Item terakhir
                                                </span>
                                            @endif
                                        </p>
                                    </td>

                                    <td class="whitespace-nowrap px-4 py-4 align-top">
                                        <span class="badge bg-slate-100 text-slate-700 ring-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:ring-slate-700">
                                            {{ $pekerjaan['modul'] }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-4 align-top">
                                        <p class="font-medium text-slate-800 dark:text-slate-200">
                                            {{ $pekerjaan['penanggung_jawab'] }}
                                        </p>
                                        <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                                            {{ $pekerjaan['peran'] }}
                                        </p>
                                    </td>

                                    <td class="whitespace-nowrap px-4 py-4 align-top">
                                        <x-status-banner :type="$pekerjaan['statusType']" compact>
                                            {{ $pekerjaan['status'] }}
                                        </x-status-banner>
                                    </td>

                                    <td class="px-4 py-4 align-top">
                                        <div class="flex items-center gap-3">
                                            <div class="h-1.5 w-24 overflow-hidden rounded-full bg-slate-200 dark:bg-slate-800">
                                                <div
                                                    class="h-full rounded-full bg-gradient-to-r from-its-600 to-sky-400"
                                                    style="width: {{ (int) $pekerjaan['progres'] }}%"
                                                    role="progressbar"
                                                    aria-valuenow="{{ (int) $pekerjaan['progres'] }}"
                                                    aria-valuemin="0"
                                                    aria-valuemax="100"
                                                    aria-label="Progres {{ $pekerjaan['nama'] }}"
                                                ></div>
                                            </div>
                                            <span class="text-xs font-semibold text-slate-600 dark:text-slate-300">
                                                {{ $pekerjaan['progres'] }}%
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-10 text-center text-sm text-slate-500 dark:text-slate-400">
                                        Belum ada fitur yang terdaftar pada backlog kelompok.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                        {{-- Kaki tabel: ringkasan dihitung di controller. --}}
                        @if ($jumlahFitur > 0)
                            <tfoot class="bg-slate-50 dark:bg-slate-900/60">
                                <tr>
                                    <td colspan="6" class="px-4 py-3 text-xs text-slate-500 dark:text-slate-400">
                                        Menampilkan
                                        <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $jumlahFitur }}</span>
                                        pekerjaan &middot; rata-rata progres
                                        <span class="font-semibold text-slate-800 dark:text-slate-200">
                                            {{ $rataProgres }}%
                                        </span>
                                    </td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </section>

    {{-- ==================================================================
     | 5. MILESTONE / ROADMAP
     * ================================================================== --}}
    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <h2 class="text-xl font-bold text-slate-900 dark:text-white">Milestone Pengembangan</h2>
        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
            Rencana 16 pekan pengerjaan proyek kelompok.
        </p>

        <ol class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
            @foreach ($milestone as $tahap)
                <li @class([
                    'card-surface p-5',
                    'border-emerald-200 dark:border-emerald-500/30' => $tahap['selesai'],
                ])>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
                            {{ $tahap['pekan'] }}
                        </span>
                        <span @class([
                            'grid h-6 w-6 place-items-center rounded-full',
                            'bg-emerald-100 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-300' => $tahap['selesai'],
                            'bg-slate-100 text-slate-400 dark:bg-slate-800 dark:text-slate-500' => ! $tahap['selesai'],
                        ])>
                            <x-icon name="check" class="h-3.5 w-3.5" />
                        </span>
                    </div>
                    <p class="mt-3 text-sm font-semibold leading-snug text-slate-800 dark:text-slate-200">
                        {{ $tahap['judul'] }}
                    </p>
                    <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                        {{ $tahap['selesai'] ? 'Selesai' : 'Dalam rencana' }}
                        @if ($loop->last) &middot; target akhir @endif
                    </p>
                </li>
            @endforeach
        </ol>
    </section>

    {{-- ==================================================================
     | 6. FORMULIR PENGUMPULAN IDE
     * ================================================================== --}}
    <section id="form-ide" class="border-t border-slate-200 bg-white py-14 dark:border-slate-800 dark:bg-slate-950/40">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-12 lg:px-8">
            <div class="lg:col-span-5">
                <h2 class="text-xl font-bold text-slate-900 dark:text-white">Kumpulkan Ide Anda</h2>
                <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                    Usulan akan masuk ke backlog kelompok dan ditinjau pada rapat
                    mingguan. Formulir ini juga menjadi contoh notifikasi form:
                    hasil validasi ditampilkan sebagai <code class="font-mono text-its-600 dark:text-its-300">&lt;x-status-banner&gt;</code>.
                </p>

                <ul class="mt-6 space-y-3 text-sm text-slate-600 dark:text-slate-400">
                    @foreach ([
                        'Judul ide minimal 5 karakter dan bersifat spesifik.',
                        'Deskripsi minimal 20 karakter, maksimal 600 karakter.',
                        'Sertakan nama pengusul agar mudah ditindaklanjuti.',
                    ] as $panduan)
                        <li class="flex items-start gap-2.5">
                            <span class="mt-0.5 inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-its-50 text-its-600 dark:bg-its-500/10 dark:text-its-300">
                                <x-icon name="check" class="h-3 w-3" />
                            </span>
                            {{ $panduan }}
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="lg:col-span-7">
                <form
                    action="{{ route('ideAgent.simpan') }}"
                    method="POST"
                    class="card-surface p-6 sm:p-7"
                    data-confirm="Kirim ide ini ke backlog kelompok?"
                >
                    @csrf
                    {{-- Pertahankan tema aktif setelah redirect (Challenge 1). --}}
                    <input type="hidden" name="mode" value="{{ $mode }}">

                    <div class="grid gap-5">
                        {{-- Judul ide --}}
                        <div>
                            <label for="judul" class="form-label">
                                Judul Ide <span class="text-rose-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="judul"
                                name="judul"
                                value="{{ old('judul') }}"
                                maxlength="120"
                                required
                                placeholder="Contoh: Agen penjadwal otomatis untuk bimbingan tugas akhir"
                                @class(['form-input', 'border-rose-400 focus:border-rose-500 focus:ring-rose-500/30' => $errors->has('judul')])
                            >
                            @error('judul')
                                <p class="mt-1.5 text-xs font-medium text-rose-600 dark:text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Kategori + pengusul --}}
                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="kategori" class="form-label">
                                    Kategori <span class="text-rose-500">*</span>
                                </label>
                                <select
                                    id="kategori"
                                    name="kategori"
                                    required
                                    @class(['form-input', 'border-rose-400 focus:border-rose-500 focus:ring-rose-500/30' => $errors->has('kategori')])
                                >
                                    <option value="" disabled @selected(old('kategori') === null)>-- Pilih kategori --</option>
                                    @foreach ($kategoriIde as $nilai => $label)
                                        <option value="{{ $nilai }}" @selected(old('kategori') === $nilai)>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori')
                                    <p class="mt-1.5 text-xs font-medium text-rose-600 dark:text-rose-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="pengusul" class="form-label">Nama Pengusul</label>
                                <input
                                    type="text"
                                    id="pengusul"
                                    name="pengusul"
                                    value="{{ old('pengusul', $profil['nama']) }}"
                                    maxlength="80"
                                    placeholder="{{ $profil['nama'] }}"
                                    class="form-input"
                                >
                                @error('pengusul')
                                    <p class="mt-1.5 text-xs font-medium text-rose-600 dark:text-rose-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div>
                            <div class="flex items-center justify-between gap-4">
                                <label for="deskripsi" class="form-label">
                                    Deskripsi Ide <span class="text-rose-500">*</span>
                                </label>
                                {{-- Penghitung karakter ditangani resources/js/app.js --}}
                                <span
                                    data-counter-for="deskripsi"
                                    data-counter-max="600"
                                    class="text-xs font-medium text-slate-400"
                                ></span>
                            </div>
                            <textarea
                                id="deskripsi"
                                name="deskripsi"
                                rows="5"
                                maxlength="600"
                                required
                                placeholder="Jelaskan singkat permasalahan yang ingin diselesaikan, cara kerja agen, dan manfaatnya bagi tim."
                                @class(['form-input resize-y', 'border-rose-400 focus:border-rose-500 focus:ring-rose-500/30' => $errors->has('deskripsi')])
                            >{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <p class="mt-1.5 text-xs font-medium text-rose-600 dark:text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Aksi --}}
                        <div class="flex flex-wrap items-center gap-3 border-t border-slate-100 pt-5 dark:border-slate-800">
                            <button type="submit" class="btn-primary">
                                <x-icon name="send" class="h-4 w-4" />
                                Kirim Ide
                            </button>
                            <button type="reset" class="btn-secondary">
                                Bersihkan
                            </button>
                            <span class="text-xs text-slate-400">
                                Data tidak disimpan ke basis data pada contoh tugas ini.
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
