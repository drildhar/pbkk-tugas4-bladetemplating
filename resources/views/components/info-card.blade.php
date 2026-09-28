{{--
 * resources/views/components/info-card.blade.php   ->   <x-info-card ... />
 * ---------------------------------------------------------------------------
 * KOMPONEN KUSTOM #1 (wajib).
 *
 * Menampilkan satu butir data profil: judul kartu, nilai utama, deskripsi,
 * ikon, serta badge status berwarna. Seluruh gaya dasar berasal dari kelas
 * `.card-surface` (lihat resources/css/app.css) sehingga konsisten dan DRY.
 *
 * PROPS
 *   title       : string|null  Judul kartu (mis. "Nomor Registrasi Pokok").
 *   value       : string|null  Nilai utama yang ditonjolkan (mis. "[NRP_MAHASISWA]").
 *   description : string|null  Penjelasan pendukung di bawah nilai.
 *   icon        : string|null  Nama ikon untuk <x-icon>, mis. "id", "mail".
 *   status      : string|null  Teks badge status (mis. "Aktif"). Kosong = tanpa badge.
 *   statusType  : string       Warna badge: info|success|warning|danger|neutral.
 *   accent      : string       Warna kotak ikon: brand|emerald|amber|rose|slate.
 *
 * SLOT
 *   $slot   : konten bebas di badan kartu (opsional).
 *   $footer : konten tambahan di kaki kartu (named slot, opsional).
 *
 * $attributes : atribut sisa (id, data-*, class tambahan) otomatis di-merge
 *               sehingga styling tetap fleksibel dari sisi pemanggil.
--}}

@props([
    'title' => null,
    'value' => null,
    'description' => null,
    'icon' => null,
    'status' => null,
    'statusType' => 'info',
    'accent' => 'brand',
])

@php
    /*
     | Peta kelas Tailwind DITULIS LENGKAP sebagai string literal (bukan
     | dirangkai dinamis seperti 'bg-'.$x.'-100') supaya tetap terdeteksi
     | oleh pemindai konten Tailwind saat proses build.
     */
    $badgeStyles = [
        'info' => 'badge bg-its-50 text-its-700 ring-its-200 dark:bg-its-500/10 dark:text-its-300 dark:ring-its-500/30',
        'success' => 'badge bg-emerald-50 text-emerald-700 ring-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-300 dark:ring-emerald-500/30',
        'warning' => 'badge bg-amber-50 text-amber-700 ring-amber-200 dark:bg-amber-500/10 dark:text-amber-300 dark:ring-amber-500/30',
        'danger' => 'badge bg-rose-50 text-rose-700 ring-rose-200 dark:bg-rose-500/10 dark:text-rose-300 dark:ring-rose-500/30',
        'neutral' => 'badge bg-slate-100 text-slate-700 ring-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:ring-slate-700',
    ];

    $accentStyles = [
        'brand' => 'bg-its-50 text-its-600 dark:bg-its-500/10 dark:text-its-300',
        'emerald' => 'bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-300',
        'amber' => 'bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-300',
        'rose' => 'bg-rose-50 text-rose-600 dark:bg-rose-500/10 dark:text-rose-300',
        'slate' => 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300',
    ];

    $badgeClass = $badgeStyles[$statusType] ?? $badgeStyles['info'];
    $accentClass = $accentStyles[$accent] ?? $accentStyles['brand'];
@endphp

<article
    {{ $attributes->merge([
        'class' => 'card-surface group relative flex h-full flex-col gap-4 p-6 hover:-translate-y-1 hover:border-its-300 hover:shadow-soft dark:hover:border-its-500/40',
    ]) }}
>
    {{-- Kepala kartu: ikon + judul + badge status --}}
    <header class="flex items-start justify-between gap-3">
        <div class="flex items-center gap-3">
            @if ($icon)
                <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl {{ $accentClass }} transition group-hover:scale-105">
                    <x-icon :name="$icon" class="h-5 w-5" />
                </span>
            @endif

            @if ($title)
                <h3 class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                    {{ $title }}
                </h3>
            @endif
        </div>

        @if ($status)
            <span class="{{ $badgeClass }}">
                <span class="h-1.5 w-1.5 rounded-full bg-current opacity-70"></span>
                {{ $status }}
            </span>
        @endif
    </header>

    {{-- Nilai utama --}}
    @if ($value)
        <p class="break-words text-lg font-bold leading-snug text-slate-900 dark:text-white">
            {{ $value }}
        </p>
    @endif

    {{-- Deskripsi pendukung --}}
    @if ($description)
        <p class="text-sm leading-relaxed text-slate-600 dark:text-slate-400">
            {{ $description }}
        </p>
    @endif

    {{-- Slot default: konten bebas dari pemanggil --}}
    @if ($slot->isNotEmpty())
        <div class="text-sm text-slate-600 dark:text-slate-400">
            {{ $slot }}
        </div>
    @endif

    {{-- Named slot opsional: kaki kartu (mis. tautan aksi) --}}
    @isset($footer)
        <footer class="mt-auto border-t border-slate-100 pt-4 text-sm dark:border-slate-800">
            {{ $footer }}
        </footer>
    @endisset
</article>
