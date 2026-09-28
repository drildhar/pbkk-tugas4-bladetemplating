# Tugas Mandiri 4 — Aplikasi Multi-View Profil Akademik

**Mata Kuliah:** Pemrograman Berbasis Kerangka Kerja (PBKK)
**Departemen Teknik Informatika — Institut Teknologi Sepuluh Nopember (ITS)**
**Topik:** Blade Templating & Integrasi Frontend Modern (Vite)

| Identitas | Nilai |
|---|---|
| Nama Mahasiswa | `Adriel Mahira Dharma` |
| NRP | `5025241097` |
| Kelas PBKK | `PBKK B` |

---

## 1. Ringkasan Fitur

| # | Ketentuan Tugas | Status | Bukti |
|---|---|---|---|
| 1 | Satu master layout (`@extends`, `@yield`, `@section`), tanpa duplikasi `<html>/<head>/<body>` | ✅ | `resources/views/layouts/app.blade.php` |
| 2 | Partial navbar & footer via `@include` | ✅ | `resources/views/partials/{navbar,footer}.blade.php` |
| 3 | Tidak ada query database di Blade (Separation of Concerns) | ✅ | Semua data disiapkan `PageController` |
| 4 | Tailwind CSS lokal via NPM + `@vite(...)`, tanpa CDN | ✅ | `resources/css/app.css`, `vite.config.js` |
| 5 | `tailwind.config.js` dengan scanning Blade presisi | ✅ | `tailwind.config.js` |
| 6 | Satu controller `PageController` menangani semua rute | ✅ | `app/Http/Controllers/PageController.php` |
| 7 | 3 rute fungsional (`/`, `/profil-mahasiswa`, `/ide-agent`) | ✅ | `routes/web.php` |
| 8 | Data dikirim dengan `view()` + `compact()` | ✅ | `PageController` |
| 9 | Komponen kustom `@1`: `<x-info-card>` (props, slot, `$attributes`) | ✅ | `resources/views/components/info-card.blade.php` |
| 10 | Komponen kustom `@2`: `<x-status-banner>` (warna dinamis per tipe) | ✅ | `resources/views/components/status-banner.blade.php` |
| 11 | Tabel fitur kelompok dengan `@forelse` + metadata `$loop` | ✅ | `resources/views/ide-agent.blade.php` |
| 12 | Formulir pengumpulan ide + notifikasi status | ✅ | `PageController@simpanIde` |
| 13 | **Challenge 1** — toggle tema `/ide-agent?mode=dark` | ✅ | `PageController::resolveDarkMode()` |
| 14 | **Challenge 2** — sapaan dinamis `/?user=Andi` | ✅ | `resources/views/beranda.blade.php` |

**Bonus di luar ketentuan (nilai tambah):**

- Komponen bantu `<x-icon>` — 40+ ikon SVG inline, sehingga **nol permintaan ke CDN**.
- Kelas gaya yang dapat dipakai ulang (`.card-surface`, `.btn-primary`, `.form-input`, …) pada `@layer components` — wujud DRY di sisi styling.
- `app/Support/ProfilAkademik.php` + `View::share()`: partial navbar/footer tidak membaca `config()` sendiri.
- Validasi server-side lengkap (pesan galat berbahasa Indonesia) + pengisian ulang `old()`.
- Peningkatan progresif JavaScript: menu mobile, tutup banner, penghitung karakter, konfirmasi kirim.
- Aksesibilitas: skip-link, `aria-current`, `role="progressbar"`, `aria-label`, kontras mode gelap.

---

## 2. Prasyarat

| Perangkat | Versi minimum |
|---|---|
| PHP | 8.2+ (diuji pada 8.5.8) |
| Composer | 2.x |
| Node.js | 20+ (diuji pada 24.20.0) |
| NPM | 10+ (diuji pada 11.19.0) |

---

## 3. Panduan Instalasi & Perintah Terminal

### Langkah 1 — Dependensi PHP

```bash
composer install
cp .env.example .env          # Windows: copy .env.example .env
php artisan key:generate
```

### Langkah 2 — Dependensi Frontend (Tailwind, PostCSS, Autoprefixer)

```bash
npm install
```

> Paket yang dipasang sudah dideklarasikan pada `package.json`:
> `tailwindcss@^3.4`, `postcss@^8.4`, `autoprefixer@^10.4`,
> `laravel-vite-plugin@^3.1`, dan `vite@^8`.

Bila ingin memasangnya secara manual dari nol:

```bash
npm install -D tailwindcss@^3.4.17 postcss@^8.4.49 autoprefixer@^10.4.20
npx tailwindcss init -p        # membuat tailwind.config.js & postcss.config.js
```

### Langkah 3 — Jalankan mode pengembangan

Dua terminal:

```bash
# Terminal 1 — aset dengan hot reload
npm run dev

# Terminal 2 — server PHP
php artisan serve
```

Buka <http://127.0.0.1:8000>.

> Ingin satu perintah saja? `composer dev` menjalankan server, Vite, queue, dan log sekaligus.

### Langkah 4 — Build produksi

```bash
npm run build
```

Hasilnya: `public/build/manifest.json` + `public/build/assets/*`. Laravel membaca
manifest tersebut secara otomatis dari `@vite([...])`.

---

## 4. Struktur Berkas

```
.
├── app/
│   ├── Http/Controllers/
│   │   └── PageController.php          # SATU controller untuk semua rute
│   ├── Providers/
│   │   └── AppServiceProvider.php      # View::share('identitas', ...)
│   └── Support/
│       └── ProfilAkademik.php          # sumber data identitas (DRY)
│
├── config/
│   └── mahasiswa.php                   # ⬅️ GANTI PLACEHOLDER DI SINI
│
├── resources/
│   ├── css/app.css                     # @tailwind base/components/utilities
│   ├── js/app.js                       # menu mobile, banner, counter, konfirmasi
│   └── views/
│       ├── layouts/app.blade.php       # MASTER LAYOUT (@yield + @vite)
│       ├── partials/
│       │   ├── navbar.blade.php        # @include + active state
│       │   └── footer.blade.php        # @include + copyright {{ date('Y') }}
│       ├── components/
│       │   ├── info-card.blade.php     # KOMPONEN #1
│       │   ├── status-banner.blade.php # KOMPONEN #2 (dukung mode compact)
│       │   └── icon.blade.php          # bonus: ikon SVG lokal
│       ├── beranda.blade.php           # Challenge 2 (?user=Andi)
│       ├── profil.blade.php            # kartu identitas + minat riset
│       └── ide-agent.blade.php         # Challenge 1 (?mode=dark) + tabel + form
│
├── routes/web.php                      # 4 rute (3 GET + 1 POST pendukung)
├── tailwind.config.js                  # content scanning presisi + darkMode: class
├── postcss.config.js                   # tailwindcss + autoprefixer
└── vite.config.js                      # entry: app.css & app.js
```

---

## 5. Rute

| Method | URI | Action | Nama rute | Keterangan |
|---|---|---|---|---|
| GET | `/` | `PageController@beranda` | `beranda` | Challenge 2: `/?user=Andi` |
| GET | `/profil-mahasiswa` | `PageController@profil` | `profilMhs` | Profil lengkap |
| GET | `/ide-agent` | `PageController@ideAgent` | `ideAgent` | Challenge 1: `?mode=dark` |
| POST | `/ide-agent` | `PageController@simpanIde` | `ideAgent.simpan` | Validasi + flash message |

---

## 6. Tantangan Ekstra (Challenge)

### Challenge 1 — Toggle Tema Dinamis

1. Buka `/ide-agent?mode=dark`.
2. `PageController::resolveDarkMode()` menangkap `mode` dari `Request` dan mengirim `$isDark = true`.
3. `layouts/app.blade.php` menambahkan kelas `dark` ke elemen `<html>` lewat `@class(['scroll-smooth', 'dark' => $isDark])`.
4. `tailwind.config.js` memakai `darkMode: 'class'`, sehingga **seluruh varian `dark:`** di halaman langsung aktif.
5. Tombol bulan/matahari di navbar membalik nilai tersebut dengan mempertahankan query string lain (`route($ruteAktif, array_merge(request()->query(), ['mode' => ...]))`).
6. Halaman juga memakai **kelas Tailwind dinamis** langsung dari `$isDark`, misalnya pada badge dan header:

```blade
<span @class([
    'badge',
    'bg-its-500/10 text-its-300 ring-its-500/30' => $isDark,
    'bg-its-50 text-its-700 ring-its-200'        => ! $isDark,
])>
```

### Challenge 2 — Alert Status Interaktif

1. Buka `/?user=Andi` (atau `/beranda?user=Rina`).
2. `PageController::beranda()` menormalkan nilai `user` (trim, buang tag HTML, potong 40 karakter) sehingga aman ditampilkan.
3. `beranda.blade.php` memakai `@isset` / `@else`:

```blade
@isset($namaPengguna)
    <x-status-banner type="success"
        :title="'Selamat datang kembali, ' . $namaPengguna . '!'"
        dismissible :autodismiss="8000">
        Senang melihat Anda lagi di portal profil akademik.
    </x-status-banner>
@else
    <x-status-banner type="info" title="Selamat datang di Portal Profil Akademik">
        ... ajakan mencoba tautan ?user=Andi ...
    </x-status-banner>
@endisset
```

> `@isset($namaPengguna)` bernilai **false** ketika nilainya `null`, sehingga
> cabang `@else` otomatis terpakai saat parameter `user` tidak dikirim.

---

## 7. Konvensi Tailwind yang Wajib Dipatuhi

Tailwind memindai kode secara **statis**. Karena itu:

- ❌ Jangan merangkai kelas: ``class="bg-{{ $warna }}-100"`` → kelas tidak akan ikut ter-build.
- ✅ Tulis kelas lengkap sebagai string literal di dalam peta (map):

```php
$badgeStyles = [
    'success' => 'badge bg-emerald-50 text-emerald-700 ring-emerald-200 ...',
    'warning' => 'badge bg-amber-50 text-amber-700 ring-amber-200 ...',
];
```

- ✅ Nilai yang benar-benar dinamis (lebar progres) memakai gaya inline
  (`style="width: 72%"`), bukan kelas hasil rangkaian string.

Kanvas pemindaian diatur di `tailwind.config.js`:

```js
content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './app/View/Components/**/*.php',
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
],
```

---

## 8. Daftar Periksa Kesiapan Repositori & Submission

### 8.1 Berkas yang tidak boleh ter-commit

`.gitignore` sudah memastikan hal ini. Verifikasi dengan:

```bash
git check-ignore -v vendor node_modules .env public/build
```

Harapan keluaran: keempatnya disebut sebagai pola yang diabaikan.
Sedangkan `.env.example` **harus tetap ter-commit**.

### 8.2 Verifikasi sebelum mengumpulkan

```bash
composer install
npm install
npm run build
php artisan view:clear && php artisan config:clear
php artisan route:list --except-vendor
php artisan serve
```

Periksa kelima URL berikut mengembalikan **HTTP 200**:

- [ ] `/`
- [ ] `/?user=Andi` → muncul banner “Selamat datang kembali, Andi!”
- [ ] `/profil-mahasiswa`
- [ ] `/ide-agent`
- [ ] `/ide-agent?mode=dark` → `<html class="dark ...">`

### 8.3 Berkas yang dikumpulkan

- [ ] Seluruh isi repositori **kecuali** `vendor/`, `node_modules/`, `.env`, `public/build/`.
- [ ] `README.md` ini.
- [ ] Tangkapan layar 3 halaman (terang + gelap) untuk lampiran laporan.

---

## 9. Petunjuk Pengujian Live Demo (3 Menit)

| Waktu | Aksi | Poin yang ditunjukkan |
|---|---|---|
| 0:00–0:20 | Tampilkan struktur folder: `layouts/app.blade.php`, `partials/`, `components/` | Prinsip DRY: satu master layout, tanpa duplikasi boilerplate |
| 0:20–0:45 | Buka `/` | Master layout + partial navbar/footer + kartu statistik dari `@forelse` |
| 0:45–1:05 | Ubah URL menjadi `/?user=Andi` | **Challenge 2**: banner sapaan dinamis; tekan ✕ untuk menutup |
| 1:05–1:35 | Buka `/profil-mahasiswa` | `<x-info-card>` dipakai ulang 6× dari array `$kartuUtama`; progress bar minat riset |
| 1:35–2:15 | Buka `/ide-agent` | Tabel fitur: tunjuk kolom **No** (`$loop->iteration`), badge “Item pertama/terakhir” (`$loop->first/last`), zebra striping (`$loop->even`), ringkasan footer tabel |
| 2:15–2:40 | Ubah URL menjadi `/ide-agent?mode=dark` | **Challenge 1**: tema gelap instan lewat `darkMode: 'class'` |
| 2:40–3:00 | Isi formulir ide dengan judul 3 karakter → Kirim (muncul error), lalu isi benar → Kirim | Validasi server-side + `<x-status-banner>`; tema gelap tetap tersimpan setelah redirect |

**Tips demo:** buka DevTools → tab *Network* untuk membuktikan seluruh aset
(`/build/assets/app-*.css`) berasal dari server lokal — **tidak ada CDN**.

---

## 10. Troubleshooting

| Gejala | Penyebab & Solusi |
|---|---|
| `Vite manifest not found at .../public/build/manifest.json` | Aset belum di-build. Jalankan `npm run build` (atau `npm run dev`), lalu `php artisan view:clear`. Jangan set `build.manifest: true` di `vite.config.js`. |
| Tampilan polos tanpa gaya | Jalankan `npm run dev` **atau** `npm run build`; pastikan `@vite([...])` ada di `layouts/app.blade.php`. |
| Kelas baru tidak muncul | Kelas dirakit dari string? Tailwind tidak dapat mendeteksinya. Tulis kelas sebagai literal dan muat ulang. |
| Perubahan Blade tidak tampil | `php artisan view:clear`. |
| Perubahan `.env`/config tidak tampil | `php artisan config:clear`. |
| `Undefined variable $isDark` | Setiap view anak wajib menerima `$isDark` dari controller; layout sudah menyiapkan fallback `$isDark ?? false`. |

---

## 11. Lisensi & Kredit

- Kerangka kerja: [Laravel](https://laravel.com) (MIT).
- Utilitas CSS: [Tailwind CSS](https://tailwindcss.com) (MIT).
- Bundler: [Vite](https://vitejs.dev) + `laravel-vite-plugin`.
- Ikon SVG: [Heroicons](https://heroicons.com) (MIT), disalin sebagai aset lokal pada `resources/views/components/icon.blade.php`.

Disusun untuk keperluan akademik mata kuliah Pemrograman Berbasis Kerangka Kerja, Departemen Teknik Informatika ITS.
