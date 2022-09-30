<?php

namespace App\Providers;

use App\Repositories\AkunRepository;
use App\Repositories\PembayaranRepository;
use App\Repositories\Impl\PembayaranRepositoryImpl;
use App\Repositories\JenisPembayaranRepository;
use App\Repositories\TransaksiRepository;
use App\Services\Impl\PembayaranServiceImpl;
use App\Services\PembayaranService;
use App\Services\TransaksiService;
use Illuminate\Support\ServiceProvider;

class PembayaranProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PembayaranRepository::class, PembayaranRepositoryImpl::class);
        $this->app->singleton(PembayaranService::class, function ($app) {
            $pembayaranRepository = $app->make(PembayaranRepository::class);
            $jenisPembayaranRepository = $app->make(JenisPembayaranRepository::class);
            $transaksiService = $app->make(TransaksiService::class);


            return new PembayaranServiceImpl(
                $pembayaranRepository,
                $jenisPembayaranRepository,
                $transaksiService
            );
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
