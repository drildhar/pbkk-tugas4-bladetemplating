<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * PortalAkademikTest
 * ---------------------------------------------------------------------------
 * Pengujian fungsional untuk seluruh halaman "Multi-View Profil Akademik",
 * termasuk kedua tantangan ekstra (Challenge 1 & Challenge 2) dan validasi
 * formulir pengumpulan ide.
 *
 * Catatan: `withoutVite()` dipakai agar pengujian tidak bergantung pada hasil
 * `npm run build`. Dengan begitu test tetap hijau di mesin mana pun.
 */
class PortalAkademikTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    /* =====================================================================
     |  RUTE 1 - BERANDA
     | ==================================================================== */

    public function test_beranda_dapat_diakses(): void
    {
        $this->get(route('beranda'))
            ->assertOk()
            ->assertSee('Portal Profil Akademik')
            ->assertSee('Fitur Unggulan Implementasi');
    }

    public function test_challenge_2_beranda_menyapa_pengguna_dari_query_string(): void
    {
        $this->get(route('beranda', ['user' => 'Andi']))
            ->assertOk()
            ->assertSee('Selamat datang kembali, Andi!');
    }

    public function test_beranda_tanpa_parameter_user_menampilkan_sambutan_umum(): void
    {
        $this->get(route('beranda'))
            ->assertOk()
            ->assertSee('Selamat datang di Portal Profil Akademik')
            ->assertDontSee('Selamat datang kembali');
    }

    public function test_parameter_user_berbahaya_dibersihkan(): void
    {
        $this->get(route('beranda', ['user' => '<script>alert(1)</script>']))
            ->assertOk()
            ->assertDontSee('<script>alert(1)</script>', false);
    }

    /* =====================================================================
     |  RUTE 2 - PROFIL MAHASISWA
     | ==================================================================== */

    public function test_profil_menampilkan_identitas_dari_config(): void
    {
        $this->get(route('profilMhs'))
            ->assertOk()
            ->assertSee(config('mahasiswa.nama'))
            ->assertSee(config('mahasiswa.nrp'))
            ->assertSee(config('mahasiswa.kelas'))
            ->assertSee('Minat Riset')
            ->assertSee('Keahlian Teknis');
    }

    /* =====================================================================
     |  RUTE 3 - IDE RISET AGENT (Challenge 1)
     | ==================================================================== */

    public function test_ide_agent_default_bertema_terang(): void
    {
        $this->get(route('ideAgent'))
            ->assertOk()
            ->assertSee('class="scroll-smooth"', false)
            ->assertSee('Terang (default)');
    }

    public function test_challenge_1_ide_agent_mode_dark_menambahkan_kelas_dark(): void
    {
        $this->get(route('ideAgent', ['mode' => 'dark']))
            ->assertOk()
            ->assertSee('class="dark scroll-smooth"', false)
            ->assertSee('Gelap (mode=dark)');
    }

    public function test_tabel_fitur_merender_metadata_loop(): void
    {
        $this->get(route('ideAgent'))
            ->assertOk()
            ->assertSee('Fitur &amp; Pembagian Tugas Kelompok', false)
            ->assertSee('Item pertama')
            ->assertSee('Item terakhir')
            ->assertSee('NARA - Nusantara Agentic Research Assistant');
    }

    /* =====================================================================
     |  RUTE 4 - FORMULIR PENGUMPULAN IDE
     | ==================================================================== */

    public function test_formulir_menolak_input_tidak_valid(): void
    {
        $this->from(route('ideAgent'))
            ->post(route('ideAgent.simpan'), [
                'judul' => 'abc',
                'kategori' => 'tidak-ada',
                'deskripsi' => 'pendek',
            ])
            ->assertRedirect(route('ideAgent'))
            ->assertSessionHasErrors(['judul', 'kategori', 'deskripsi']);
    }

    public function test_formulir_menerima_input_valid_dan_mengirim_flash_message(): void
    {
        $this->post(route('ideAgent.simpan'), [
            'judul' => 'Agen penjadwal bimbingan otomatis',
            'kategori' => 'agent',
            'deskripsi' => 'Agen menyusun jadwal bimbingan dan mengirim pengingat otomatis kepada mahasiswa.',
            'pengusul' => 'Andi',
            'mode' => 'dark',
        ])
            ->assertRedirect(route('ideAgent', ['mode' => 'dark']))
            ->assertSessionHas('status');

        // Flash message dirender sebagai <x-status-banner> pada halaman tujuan.
        $this->followRedirects(
            $this->post(route('ideAgent.simpan'), [
                'judul' => 'Agen perangkum literatur otomatis',
                'kategori' => 'riset',
                'deskripsi' => 'Agen mengumpulkan referensi lalu merangkumnya menjadi tinjauan pustaka singkat.',
            ])
        )->assertOk()->assertSee('Ide berhasil dikumpulkan');
    }

    /* =====================================================================
     |  KONTRAK RUTE
     | ==================================================================== */

    public function test_seluruh_nama_rute_terdaftar(): void
    {
        foreach (['beranda', 'profilMhs', 'ideAgent', 'ideAgent.simpan'] as $nama) {
            $this->assertTrue(
                app('router')->has($nama),
                "Nama rute [{$nama}] tidak terdaftar."
            );
        }
    }
}
