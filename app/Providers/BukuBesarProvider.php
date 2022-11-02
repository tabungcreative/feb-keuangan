<?php

namespace App\Providers;

use App\Repositories\AkunRepository;
use App\Repositories\TransaksiRepository;
use App\Services\BukuBesarService;
use App\Services\Impl\BukuBesarServiceImpl;
use Illuminate\Support\ServiceProvider;

class BukuBesarProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(BukuBesarService::class, function ($app){
            $akunRepository = $app->make(AkunRepository::class);
            $transaksiRepository = $app->make(TransaksiRepository::class);
            return new BukuBesarServiceImpl($akunRepository, $transaksiRepository);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
