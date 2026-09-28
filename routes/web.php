<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Tugas Mandiri 4 PBKK
|--------------------------------------------------------------------------
| Seluruh rute ditangani oleh SATU controller: PageController.
|
|  GET  /                  -> PageController@beranda      (Challenge 2: ?user=)
|  GET  /profil-mahasiswa  -> PageController@profil
|  GET  /ide-agent         -> PageController@ideAgent     (Challenge 1: ?mode=dark)
|  POST /ide-agent         -> PageController@simpanIde    (notifikasi form)
|
| Nama rute (->name(...)) dipakai oleh partial navbar untuk penanda active state
| dan oleh helper route() saat membangun URL toggle tema.
*/

// RUTE 1 - Beranda. Contoh Challenge 2: /?user=Andi
Route::get('/', [PageController::class, 'beranda'])->name('beranda');

// RUTE 2 - Profil mahasiswa (kartu identitas via <x-info-card>).
Route::get('/profil-mahasiswa', [PageController::class, 'profil'])->name('profilMhs');

// RUTE 3 - Ide riset platform Agentic AI. Contoh Challenge 1: /ide-agent?mode=dark
Route::get('/ide-agent', [PageController::class, 'ideAgent'])->name('ideAgent');

// RUTE 4 - Penerima kiriman formulir ide (validasi + flash message).
Route::post('/ide-agent', [PageController::class, 'simpanIde'])->name('ideAgent.simpan');
