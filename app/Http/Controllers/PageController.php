<?php

namespace App\Http\Controllers;

use App\Support\ProfilAkademik;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * PageController
 * ---------------------------------------------------------------------------
 * SATU-SATUNYA controller yang melayani seluruh halaman aplikasi
 * "Multi-View Profil Akademik" (Tugas Mandiri 4 PBKK).
 *
 * Tanggung jawab controller (Separation of Concerns):
 *   1. Menangkap input dari Request (query string `mode`, `user`, dsb.).
 *   2. Menyiapkan data MATANG (array multidimensi) untuk dikirim ke View.
 *   3. Memanggil helper `view()` dengan `compact()` / array passing yang bersih.
 *
 * View DILARANG melakukan query database atau logika berat apa pun.
 */
class PageController extends Controller
{
    /* =====================================================================
     |  RUTE 1 - BERANDA
     |  GET /  &&  GET /?user=Andi   (Challenge 2: alert status interaktif)
     | ==================================================================== */

    /**
     * Halaman beranda / portal utama.
     *
     * Challenge 2:
     *   Jika query string `user` diisi (mis. `/beranda?user=Andi`), halaman
     *   menampilkan komponen <x-status-banner> yang menyapa pengguna secara
     *   dinamis. Bila kosong, banner sambutan umum yang ditampilkan.
     */
    public function beranda(Request $request): View
    {
        $namaPengguna = $this->normalisasiNama($request->query('user'));

        $statistik = [
            [
                'kode' => 'halaman',
                'ikon' => 'layers',
                'label' => 'Halaman Terdaftar',
                'nilai' => '3',
                'satuan' => 'rute aktif',
                'deskripsi' => 'Beranda, Profil Mahasiswa, dan Ide Riset Agent.',
            ],
            [
                'kode' => 'komponen',
                'ikon' => 'puzzle',
                'label' => 'Blade Component',
                'nilai' => '2',
                'satuan' => 'komponen kustom',
                'deskripsi' => 'info-card dan status-banner dengan named slot.',
            ],
            [
                'kode' => 'aset',
                'ikon' => 'bolt',
                'label' => 'Bundler',
                'nilai' => 'Vite 8',
                'satuan' => 'Tailwind v3 lokal',
                'deskripsi' => 'Tanpa CDN eksternal, 100% pipeline NPM.',
            ],
            [
                'kode' => 'arsitektur',
                'ikon' => 'cube',
                'label' => 'Arsitektur',
                'nilai' => 'MVC',
                'satuan' => 'satu master layout',
                'deskripsi' => 'Prinsip DRY lewat @extends, @yield, dan @include.',
            ],
        ];

        $fiturUnggulan = [
            [
                'ikon' => 'sparkles',
                'judul' => 'Blade Templating Modular',
                'deskripsi' => 'Satu master layout, partial navbar/footer, dan komponen anonim yang dapat dipakai ulang.',
            ],
            [
                'ikon' => 'shield',
                'judul' => 'Data Matang dari Controller',
                'deskripsi' => 'Seluruh query dan transformasi data terjadi di PageController, bukan di dalam berkas Blade.',
            ],
            [
                'ikon' => 'cpu',
                'judul' => 'Agentic AI Showcase',
                'deskripsi' => 'Halaman ide riset menampilkan peta fitur, pembagian tugas tim, serta roadmap pengembangan agen.',
            ],
            [
                'ikon' => 'palette',
                'judul' => 'Tema Terang & Gelap',
                'deskripsi' => 'Toggle tema dinamis berbasis query string `mode` memanfaatkan varian dark: dari Tailwind.',
            ],
        ];

        $alurKerja = [
            'Request masuk ke routes/web.php',
            'PageController menyiapkan data matang',
            'View blade merender master layout',
            'Vite menyajikan aset CSS & JS lokal',
        ];

        $profil = $this->identitas();
        $isDark = $this->resolveDarkMode($request);

        return view('beranda', compact(
            'profil',
            'isDark',
            'namaPengguna',
            'statistik',
            'fiturUnggulan',
            'alurKerja',
        ));
    }

    /* =====================================================================
     |  RUTE 2 - PROFIL MAHASISWA
     |  GET /profil-mahasiswa
     | ==================================================================== */

    /**
     * Halaman profil akademik lengkap.
     * Seluruh kartu dirender oleh komponen <x-info-card> memakai data dari
     * config/mahasiswa.php (array multidimensi).
     */
    public function profil(Request $request): View
    {
        $profil = $this->identitas();

        $kartuUtama = [
            [
                'ikon' => 'user',
                'judul' => 'Nama Lengkap',
                'nilai' => $profil['nama'],
                'deskripsi' => 'Penulis utama sekaligus pemilik portal profil akademik ini.',
                'status' => 'Terdaftar',
                'statusType' => 'success',
            ],
            [
                'ikon' => 'id',
                'judul' => 'Nomor Registrasi Pokok',
                'nilai' => $profil['nrp'],
                'deskripsi' => 'Identitas tunggal mahasiswa pada sistem akademik ITS.',
                'status' => 'Aktif',
                'statusType' => 'info',
            ],
            [
                'ikon' => 'academic',
                'judul' => 'Kelas PBKK',
                'nilai' => $profil['kelas'],
                'deskripsi' => 'Kelas mata kuliah Pemrograman Berbasis Kerangka Kerja.',
                'status' => 'Semester Genap',
                'statusType' => 'neutral',
            ],
            [
                'ikon' => 'building',
                'judul' => 'Departemen',
                'nilai' => $profil['departemen'],
                'deskripsi' => $profil['fakultas'],
                'status' => 'FTEIC',
                'statusType' => 'neutral',
            ],
            [
                'ikon' => 'mail',
                'judul' => 'Surel Institusi',
                'nilai' => $profil['email'],
                'deskripsi' => 'Kanal komunikasi resmi untuk keperluan akademik.',
                'status' => 'Terverifikasi',
                'statusType' => 'success',
            ],
            [
                'ikon' => 'pin',
                'judul' => 'Domisili',
                'nilai' => $profil['lokasi'],
                'deskripsi' => 'Lokasi studi dan aktivitas perkuliahan sehari-hari.',
                'status' => 'On-site',
                'statusType' => 'warning',
            ],
        ];

        $minatRiset = $profil['minat_riset'];
        $keahlian = $profil['keahlian'];
        $isDark = $this->resolveDarkMode($request);

        $timeline = [
            [
                'periode' => '2023',
                'judul' => 'Fondasi Pemrograman',
                'deskripsi' => 'Struktur data, algoritma, dan pemrograman prosedural.',
            ],
            [
                'periode' => '2024',
                'judul' => 'Pemrograman Berorientasi Objek',
                'deskripsi' => 'Java, pemodelan kelas, dan pengenalan pola desain.',
            ],
            [
                'periode' => '2025',
                'judul' => 'Pengembangan Aplikasi Web',
                'deskripsi' => 'HTML semantik, CSS modern, JavaScript, dan basis data relasional.',
            ],
            [
                'periode' => '2026',
                'judul' => 'Pemrograman Berbasis Kerangka Kerja',
                'deskripsi' => 'Laravel MVC, Blade Templating, dan integrasi Vite + Tailwind CSS.',
            ],
        ];

        return view('profil', compact(
            'profil',
            'isDark',
            'kartuUtama',
            'minatRiset',
            'keahlian',
            'timeline',
        ));
    }

    /* =====================================================================
     |  RUTE 3 - IDE RISET AGENT
     |  GET /ide-agent  &&  GET /ide-agent?mode=dark   (Challenge 1)
     | ==================================================================== */

    /**
     * Halaman ide riset platform "Agentic AI Desktop/Web Kelompok".
     *
     * Challenge 1:
     *   Parameter `mode=dark` ditangkap dari Request, lalu diteruskan sebagai
     *   boolean $isDark ke layout. Layout menambahkan kelas `dark` pada <html>
     *   sehingga varian `dark:` Tailwind aktif secara elegan.
     */
    public function ideAgent(Request $request): View
    {
        $isDark = $this->resolveDarkMode($request);
        $mode = $isDark ? 'dark' : 'light';
        $profil = $this->identitas();

        $proyek = [
            'nama' => 'NARA - Nusantara Agentic Research Assistant',
            'tagline' => 'Platform Agentic AI Desktop & Web untuk riset akademik kolaboratif.',
            'deskripsi' => 'NARA adalah agen cerdas yang mampu menyusun rencana riset, '
                .'mengumpulkan referensi, merangkum literatur, hingga menyusun draf '
                .'laporan secara otonom. Aplikasi tersedia dalam dua kanal: klien '
                .'desktop untuk pekerjaan berat (analisis berkas lokal, indeks dokumen) '
                .'dan antarmuka web untuk kolaborasi tim secara real-time.',
            'arsitektur' => [
                ['lapisan' => 'Presentation', 'teknologi' => 'Laravel Blade + Vite + Tailwind CSS', 'fungsi' => 'Merender antarmuka multi-view dan komponen reusable.'],
                ['lapisan' => 'Application', 'teknologi' => 'Laravel Controller & Service', 'fungsi' => 'Menyiapkan data matang, orkestrasi use-case, dan validasi input.'],
                ['lapisan' => 'Agent Runtime', 'teknologi' => 'Python + LLM Orchestrator', 'fungsi' => 'Planner, tool-calling, memory, dan evaluasi hasil agen.'],
                ['lapisan' => 'Knowledge', 'teknologi' => 'Vector Store + RAG', 'fungsi' => 'Indeks dokumen riset dan pencarian semantik.'],
                ['lapisan' => 'Data', 'teknologi' => 'SQLite / PostgreSQL', 'fungsi' => 'Menyimpan riwayat riset, catatan, dan metadata pengguna.'],
            ],
            'metrik' => [
                ['label' => 'Target Rilis', 'nilai' => 'Minggu ke-16'],
                ['label' => 'Kanal Distribusi', 'nilai' => 'Desktop + Web'],
                ['label' => 'Anggota Tim', 'nilai' => '4 Orang'],
            ],
        ];

        /*
         | Tabel fitur & pembagian tugas kelompok.
         | Dirender dengan @forelse + metadata $loop
         | ($loop->iteration, $loop->first, $loop->last, $loop->even, $loop->remaining).
         */
        $fitur = [
            [
                'nama' => 'Agent Planner & Task Decomposition',
                'modul' => 'Agent Runtime',
                'penanggung_jawab' => $profil['nama'],
                'peran' => 'Ketua & Integrator',
                'status' => 'Selesai',
                'statusType' => 'success',
                'progres' => 100,
                'prioritas' => 'Tinggi',
            ],
            [
                'nama' => 'Document Ingestion & Vector Indexing',
                'modul' => 'Knowledge',
                'penanggung_jawab' => 'Anggota 2 ('.$profil['nrp'].')',
                'peran' => 'Data Engineer',
                'status' => 'Berjalan',
                'statusType' => 'info',
                'progres' => 72,
                'prioritas' => 'Tinggi',
            ],
            [
                'nama' => 'Multi-View Dashboard (Blade + Vite)',
                'modul' => 'Presentation',
                'penanggung_jawab' => 'Anggota 3',
                'peran' => 'Frontend Engineer',
                'status' => 'Berjalan',
                'statusType' => 'info',
                'progres' => 65,
                'prioritas' => 'Sedang',
            ],
            [
                'nama' => 'Tool-Calling & Sandbox Eksekusi',
                'modul' => 'Agent Runtime',
                'penanggung_jawab' => 'Anggota 4',
                'peran' => 'Backend Engineer',
                'status' => 'Tertunda',
                'statusType' => 'warning',
                'progres' => 30,
                'prioritas' => 'Tinggi',
            ],
            [
                'nama' => 'Collaborative Workspace & Sinkronisasi',
                'modul' => 'Application',
                'penanggung_jawab' => 'Anggota 2',
                'peran' => 'Full-stack Engineer',
                'status' => 'Belum Mulai',
                'statusType' => 'danger',
                'progres' => 5,
                'prioritas' => 'Rendah',
            ],
        ];

        $milestone = [
            ['pekan' => 'Pekan 1-2', 'judul' => 'Riset & Perumusan Masalah', 'selesai' => true],
            ['pekan' => 'Pekan 3-6', 'judul' => 'Prototipe Agent Runtime', 'selesai' => true],
            ['pekan' => 'Pekan 7-10', 'judul' => 'Integrasi Web & Desktop', 'selesai' => false],
            ['pekan' => 'Pekan 11-14', 'judul' => 'Pengujian & Evaluasi', 'selesai' => false],
            ['pekan' => 'Pekan 15-16', 'judul' => 'Dokumentasi & Demo Akhir', 'selesai' => false],
        ];

        $kategoriIde = [
            'agent' => 'Agentic AI & Orkestrasi LLM',
            'desktop' => 'Aplikasi Desktop',
            'web' => 'Aplikasi Web',
            'riset' => 'Metodologi & Riset',
        ];

        // Angka ringkasan dihitung di controller, bukan di dalam Blade.
        $rataProgres = $fitur === [] ? 0 : (int) round(collect($fitur)->avg('progres'));
        $jumlahFitur = count($fitur);

        return view('ide-agent', compact(
            'profil',
            'isDark',
            'mode',
            'proyek',
            'fitur',
            'milestone',
            'kategoriIde',
            'rataProgres',
            'jumlahFitur',
        ));
    }

    /* =====================================================================
     |  RUTE 4 - SIMPAN IDE (pendukung formulir / notifikasi form)
     |  POST /ide-agent
     | ==================================================================== */

    /**
     * Memvalidasi kiriman formulir ide lalu mengembalikan pengguna ke halaman
     * ide-agent dengan flash message. Pesan inilah yang dirender oleh
     * <x-status-banner> sebagai notifikasi form (success / error).
     */
    public function simpanIde(Request $request): RedirectResponse
    {
        $validated = $request->validate(
            [
                'judul' => ['required', 'string', 'min:5', 'max:120'],
                'kategori' => ['required', 'string', 'in:agent,desktop,web,riset'],
                'deskripsi' => ['required', 'string', 'min:20', 'max:600'],
                'pengusul' => ['nullable', 'string', 'max:80'],
                'mode' => ['nullable', 'string', 'in:light,dark'],
            ],
            [
                'judul.required' => 'Judul ide wajib diisi.',
                'judul.min' => 'Judul ide minimal 5 karakter agar cukup deskriptif.',
                'kategori.required' => 'Silakan pilih salah satu kategori ide.',
                'kategori.in' => 'Kategori ide yang dipilih tidak dikenali.',
                'deskripsi.required' => 'Deskripsi ide wajib diisi.',
                'deskripsi.min' => 'Deskripsi ide minimal 20 karakter.',
                'deskripsi.max' => 'Deskripsi ide maksimal 600 karakter.',
            ],
        );

        // Field `pengusul` bersifat opsional, sehingga key-nya bisa saja tidak
        // ada pada $validated. Gunakan null-coalescing sebelum operator ?:.
        $pengusul = ($validated['pengusul'] ?? null) ?: (string) $this->identitas()['nama'];

        // Redirect kembali ke halaman ide-agent dengan mempertahankan tema aktif.
        $redirect = redirect()->route('ideAgent', array_filter([
            'mode' => $validated['mode'] ?? null,
        ]));

        return $redirect->with('status', [
            'type' => 'success',
            'title' => 'Ide berhasil dikumpulkan',
            'message' => sprintf(
                'Terima kasih, %s! Ide "%s" pada kategori %s telah masuk ke backlog kelompok.',
                $pengusul,
                $validated['judul'],
                $this->labelKategori($validated['kategori']),
            ),
        ]);
    }

    /* =====================================================================
     |  HELPER PRIVAT (dipakai lintas method - DRY)
     | ==================================================================== */

    /**
     * Mengambil identitas mahasiswa dari config sebagai array asosiatif.
     * Semua view cukup menerima array ini, bukan membaca config sendiri.
     *
     * @return array<string, mixed>
     */
    private function identitas(): array
    {
        return ProfilAkademik::data();
    }

    /**
     * Challenge 1: menangkap parameter `mode` dari query string.
     * Mengembalikan true bila pengguna meminta tema gelap.
     */
    private function resolveDarkMode(Request $request): bool
    {
        return $request->query('mode') === 'dark';
    }

    /**
     * Challenge 2: normalisasi nama pengguna dari query string
     * agar aman ditampilkan (trim, batas panjang, buang tag HTML).
     */
    private function normalisasiNama(mixed $nama): ?string
    {
        if (! is_string($nama)) {
            return null;
        }

        $bersih = trim(strip_tags($nama));

        return $bersih === '' ? null : mb_substr($bersih, 0, 40);
    }

    /** Label manusiawi untuk kategori ide (dipakai pada flash message). */
    private function labelKategori(string $kategori): string
    {
        return [
            'agent' => 'Agentic AI & Orkestrasi LLM',
            'desktop' => 'Aplikasi Desktop',
            'web' => 'Aplikasi Web',
            'riset' => 'Metodologi & Riset',
        ][$kategori] ?? $kategori;
    }
}
