<?php

namespace App\Providers;

use App\Support\ProfilAkademik;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /*
         | Membagikan identitas mahasiswa ke SEMUA view sebagai $identitas.
         | Partial navbar & footer memakainya langsung, sehingga mereka tidak
         | perlu membaca config/database sendiri (menjaga Separation of Concerns).
         */
        View::share('identitas', ProfilAkademik::data());
    }
}
