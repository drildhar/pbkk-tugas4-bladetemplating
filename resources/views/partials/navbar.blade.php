{{--
 * resources/views/partials/navbar.blade.php
 * ---------------------------------------------------------------------------
 * PARTIAL NAVIGASI (dipanggil via @include('partials.navbar') dari master layout).
 *
 * Fitur:
 *   - Responsif: menu penuh di layar >= md, panel lipat di layar kecil.
 *   - Active state indicator: kelas `nav-link-active` + atribut aria-current
 *     ditentukan dari nama rute aktif (request()->route()->getName()).
 *   - Toggle tema: menautkan ke rute yang sedang dibuka dengan query `mode`
 *     yang dibalik (Challenge 1 -> /ide-agent?mode=dark).
 *
 * Variabel $isDark diwarisi otomatis dari master layout (@include berbagi scope).
--}}

@php
    $isDark = $isDark ?? false;

    $ruteAktif = request()->route()?->getName() ?? 'beranda';

    // Daftar menu disusun sebagai array agar mudah ditambah (loop, bukan copy-paste).
    $menuNavigasi = [
        ['rute' => 'beranda', 'label' => 'Beranda', 'ikon' => 'home'],
        ['rute' => 'profilMhs', 'label' => 'Profil Mahasiswa', 'ikon' => 'user'],
        ['rute' => 'ideAgent', 'label' => 'Ide Riset Agent', 'ikon' => 'beaker'],
    ];

    // Bangun URL toggle tema: pertahankan query yang ada (mis. ?user=Andi) dan balik `mode`.
    $queryToggle = array_merge(request()->query(), ['mode' => $isDark ? 'light' : 'dark']);
    $urlToggle = route($ruteAktif, $queryToggle);
@endphp

<header class="sticky top-0 z-50 border-b border-slate-200/80 bg-white/85 backdrop-blur-md transition-colors duration-300 dark:border-slate-800 dark:bg-slate-950/85">
    <nav
        class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8"
        aria-label="Navigasi utama"
    >
        {{-- ---------------------------------------------------------------
         | Merek / logo aplikasi
         * --------------------------------------------------------------- --}}
        <a href="{{ route('beranda') }}" class="flex items-center gap-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-its-500 focus:ring-offset-2 dark:focus:ring-offset-slate-950">
            <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-gradient-to-br from-its-600 to-sky-500 text-xs font-black tracking-tight text-white shadow-sm">
                PBKK
            </span>
            <span class="leading-tight">
                <span class="block text-sm font-bold text-slate-900 dark:text-white">
                    Portal Profil Akademik
                </span>
                <span class="block text-xs text-slate-500 dark:text-slate-400">
                    {{ $identitas['kelas'] }} &middot; {{ $identitas['nrp'] }}
                </span>
            </span>
        </a>

        {{-- ---------------------------------------------------------------
         | Menu desktop: loop + indikator active state
         * --------------------------------------------------------------- --}}
        <div class="hidden items-center gap-1 md:flex">
            @foreach ($menuNavigasi as $menu)
                <a
                    href="{{ route($menu['rute']) }}"
                    @class([
                        'nav-link inline-flex items-center gap-1.5',
                        'nav-link-active' => $ruteAktif === $menu['rute'],
                    ])
                    @if ($ruteAktif === $menu['rute']) aria-current="page" @endif
                >
                    <x-icon :name="$menu['ikon']" class="h-4 w-4" />
                    {{ $menu['label'] }}
                </a>
            @endforeach
        </div>

        {{-- ---------------------------------------------------------------
         | Aksi kanan: toggle tema + tombol menu mobile
         * --------------------------------------------------------------- --}}
        <div class="flex items-center gap-2">
            {{-- Challenge 1: masuk/kembali dari tema gelap lewat query `mode`. --}}
            <a
                href="{{ $urlToggle }}"
                class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-its-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white"
                title="{{ $isDark ? 'Ganti ke tema terang' : 'Ganti ke tema gelap' }}"
                aria-label="{{ $isDark ? 'Ganti ke tema terang' : 'Ganti ke tema gelap' }}"
            >
                <x-icon :name="$isDark ? 'sun' : 'moon'" class="h-5 w-5" />
            </a>

            <button
                type="button"
                data-nav-toggle
                aria-expanded="false"
                aria-controls="menu-mobile"
                class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 transition hover:bg-slate-100 md:hidden dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300"
            >
                <span class="sr-only">Buka menu navigasi</span>
                <x-icon name="menu" class="h-5 w-5" />
            </button>
        </div>
    </nav>

    {{-- ---------------------------------------------------------------
     | Panel menu mobile (disembunyikan default, dikendalikan app.js)
     * --------------------------------------------------------------- --}}
    <div id="menu-mobile" data-nav-menu class="hidden border-t border-slate-200 px-4 pb-4 pt-2 md:hidden dark:border-slate-800">
        <div class="flex flex-col gap-1">
            @foreach ($menuNavigasi as $menu)
                <a
                    href="{{ route($menu['rute']) }}"
                    @class([
                        'nav-link inline-flex items-center gap-2',
                        'nav-link-active' => $ruteAktif === $menu['rute'],
                    ])
                    @if ($ruteAktif === $menu['rute']) aria-current="page" @endif
                >
                    <x-icon :name="$menu['ikon']" class="h-4 w-4" />
                    {{ $menu['label'] }}
                </a>
            @endforeach
        </div>
    </div>
</header>
