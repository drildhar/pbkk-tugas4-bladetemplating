{{--
 * resources/views/components/status-banner.blade.php  ->  <x-status-banner ... />
 * ---------------------------------------------------------------------------
 * KOMPONEN KUSTOM #2 (wajib).
 *
 * Menampilkan pesan notifikasi / sambutan dengan warna yang mengikuti `type`.
 * Dipakai untuk:
 *   - Challenge 2      : sapaan dinamis "/?user=Andi" pada halaman Beranda.
 *   - Notifikasi form  : hasil validasi pengumpulan ide pada halaman Ide Riset.
 *   - Pesan galat      : daftar kesalahan validasi ($errors->all()).
 *   - Badge status     : mode ringkas (compact) di dalam tabel fitur kelompok.
 *
 * PROPS
 *   type        : string  success | warning | danger | info  (default: info)
 *   title       : string|null  Judul tebal opsional.
 *   dismissible : bool    Tampilkan tombol tutup (ditangani resources/js/app.js).
 *   autodismiss : int     Milidetik sebelum banner menutup sendiri (0 = nonaktif).
 *   compact     : bool    Tampilan ringkas (pill) untuk dipakai di dalam tabel.
 *   icon        : bool    Tampilkan ikon status (default: true).
 *
 * SLOT
 *   $slot    : isi pesan utama (teks/HTML sederhana).
 *   $actions : named slot opsional untuk tombol aksi di sisi kanan.
 *
 * CATATAN PENTING
 *   Seluruh kelas Tailwind pada peta `$variants` ditulis sebagai string LITERAL
 *   supaya tetap terdeteksi pemindai konten Tailwind. Jangan pernah merangkai
 *   kelas secara dinamis (mis. "bg-{$type}-100") karena akan hilang saat build.
--}}

@props([
    'type' => 'info',
    'title' => null,
    'dismissible' => false,
    'autodismiss' => 0,
    'compact' => false,
    'icon' => true,
])

@php
    $variants = [
        'success' => [
            'wrapper' => 'border-emerald-200 bg-emerald-50 text-emerald-800 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-200',
            'iconWrap' => 'bg-emerald-100 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-300',
            'icon' => 'check-circle',
            'title' => 'text-emerald-900 dark:text-emerald-100',
            'close' => 'text-emerald-600 hover:bg-emerald-100 dark:text-emerald-300 dark:hover:bg-emerald-500/20',
            'role' => 'status',
        ],
        'warning' => [
            'wrapper' => 'border-amber-200 bg-amber-50 text-amber-800 dark:border-amber-500/30 dark:bg-amber-500/10 dark:text-amber-200',
            'iconWrap' => 'bg-amber-100 text-amber-600 dark:bg-amber-500/20 dark:text-amber-300',
            'icon' => 'warning',
            'title' => 'text-amber-900 dark:text-amber-100',
            'close' => 'text-amber-600 hover:bg-amber-100 dark:text-amber-300 dark:hover:bg-amber-500/20',
            'role' => 'status',
        ],
        'danger' => [
            'wrapper' => 'border-rose-200 bg-rose-50 text-rose-800 dark:border-rose-500/30 dark:bg-rose-500/10 dark:text-rose-200',
            'iconWrap' => 'bg-rose-100 text-rose-600 dark:bg-rose-500/20 dark:text-rose-300',
            'icon' => 'error',
            'title' => 'text-rose-900 dark:text-rose-100',
            'close' => 'text-rose-600 hover:bg-rose-100 dark:text-rose-300 dark:hover:bg-rose-500/20',
            'role' => 'alert',
        ],
        'info' => [
            'wrapper' => 'border-its-200 bg-its-50 text-its-800 dark:border-its-500/30 dark:bg-its-500/10 dark:text-its-200',
            'iconWrap' => 'bg-its-100 text-its-600 dark:bg-its-500/20 dark:text-its-300',
            'icon' => 'info',
            'title' => 'text-its-900 dark:text-its-100',
            'close' => 'text-its-600 hover:bg-its-100 dark:text-its-300 dark:hover:bg-its-500/20',
            'role' => 'status',
        ],
    ];

    $style = $variants[$type] ?? $variants['info'];

    // Dua varian bentuk: banner penuh (notifikasi) dan pill ringkas (badge tabel).
    $shell = $compact
        ? 'inline-flex items-center gap-1.5 rounded-lg px-2.5 py-1 text-xs font-semibold'
        : 'flex items-start gap-3 rounded-xl px-4 py-3.5 text-sm shadow-sm animate-fade-in-up';
@endphp

<div
    {{ $attributes->merge(['class' => $shell . ' border ' . $style['wrapper']]) }}
    role="{{ $style['role'] }}"
    data-banner
    @if ((int) $autodismiss > 0) data-autodismiss="{{ (int) $autodismiss }}" @endif
>
    {{-- Ikon status: ukuran menyesuaikan mode compact / penuh. --}}
    @if ($icon && $compact)
        <x-icon :name="$style['icon']" class="h-3.5 w-3.5 shrink-0" />
    @elseif ($icon)
        <span class="mt-0.5 inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg {{ $style['iconWrap'] }}">
            <x-icon :name="$style['icon']" class="h-4 w-4" />
        </span>
    @endif

    @if ($compact)
        {{-- Mode ringkas: teks langsung, tanpa pembungkus blok. --}}
        @if ($title)
            <span class="font-semibold">{{ $title }}</span>
        @endif
        <span>{{ $slot }}</span>
    @else
        {{-- Mode penuh: judul opsional + isi pesan. --}}
        <div class="min-w-0 flex-1">
            @if ($title)
                <p class="font-semibold {{ $style['title'] }}">{{ $title }}</p>
            @endif

            <div class="{{ $title ? 'mt-0.5 opacity-90' : '' }}">
                {{ $slot }}
            </div>
        </div>

        {{-- Named slot opsional untuk tombol aksi. --}}
        @isset($actions)
            <div class="shrink-0">{{ $actions }}</div>
        @endisset

        {{-- Tombol tutup (ditangani resources/js/app.js). --}}
        @if ($dismissible)
            <button
                type="button"
                data-banner-close
                aria-label="Tutup notifikasi"
                class="shrink-0 rounded-lg p-1 transition {{ $style['close'] }}"
            >
                <x-icon name="close" class="h-4 w-4" />
            </button>
        @endif
    @endif
</div>
