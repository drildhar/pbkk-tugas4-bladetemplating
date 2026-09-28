<?php

namespace App\Support;

/**
 * ProfilAkademik
 * ---------------------------------------------------------------------------
 * Sumber data identitas mahasiswa yang dipakai bersama oleh:
 *   - PageController  (mengirim ke view sebagai $profil)
 *   - AppServiceProvider (membagikan ke SELURUH view sebagai $identitas,
 *     sehingga partial navbar/footer tidak perlu membaca config sendiri).
 *
 * Dengan begitu tidak ada satu pun berkas Blade yang menyentuh config/database:
 * view benar-benar hanya menampilkan data matang (Separation of Concerns).
 */
class ProfilAkademik
{
    /**
     * Data identitas lengkap dalam bentuk array asosiatif.
     *
     * @return array<string, mixed>
     */
    public static function data(): array
    {
        $nama = (string) config('mahasiswa.nama');

        return [
            'nama' => $nama,
            'inisial' => self::inisial($nama),
            'nrp' => config('mahasiswa.nrp'),
            'kelas' => config('mahasiswa.kelas'),
            'departemen' => config('mahasiswa.departemen'),
            'fakultas' => config('mahasiswa.fakultas'),
            'institusi' => config('mahasiswa.institusi'),
            'program_studi' => config('mahasiswa.program_studi'),
            'angkatan' => config('mahasiswa.angkatan'),
            'email' => config('mahasiswa.email'),
            'lokasi' => config('mahasiswa.lokasi'),
            'minat_riset' => config('mahasiswa.minat_riset', []),
            'keahlian' => config('mahasiswa.keahlian', []),
        ];
    }

    /**
     * Inisial nama untuk avatar teks.
     * Contoh: "[NAMA_LENGKAP_MAHASISWA]" -> "N".
     */
    public static function inisial(string $nama): string
    {
        $huruf = preg_replace('/[^A-Za-z]/', '', $nama) ?? '';

        return strtoupper(mb_substr($huruf !== '' ? $huruf : 'M', 0, 1));
    }
}
