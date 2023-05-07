<?php

namespace App\Providers;

use Filament\Facades\Filament;
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
//        Filament::serving(function () {
//            Filament::registerStyles([
//                asset('filament/assets/css/leaflet.css'),
//                asset('filament/assets/css/geosearch.css'),
//            ]);
//            Filament::registerScripts([
//                asset('filament/assets/js/leaflet.js'),
//                asset('filament/assets/js/geosearch.umd.js'),
//            ], true);
//        });
    }
}
