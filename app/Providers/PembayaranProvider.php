<?php

namespace App\Providers;

use App\Repositories\AkunRepository;
use App\Repositories\PembayaranRepository;
use App\Repositories\Impl\PembayaranRepositoryImpl;
use App\Repositories\JenisPembayaranRepository;
use App\Repositories\TransaksiRepository;
use App\Services\Impl\PembayaranServiceImpl;
use App\Services\PembayaranService;
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
            $akunRepository = $app->make(AkunRepository::class);
            $transaksiRepository = $app->make(TransaksiRepository::class);
            $jenisPembayaranRepository = $app->make(JenisPembayaranRepository::class);

            return new PembayaranServiceImpl(
                $pembayaranRepository,
                $akunRepository,
                $transaksiRepository,
                $jenisPembayaranRepository
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
