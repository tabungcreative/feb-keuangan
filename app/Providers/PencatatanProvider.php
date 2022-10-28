<?php

namespace App\Providers;

use App\Repositories\AkunRepository;
use App\Repositories\TransaksiRepository;
use App\Services\Impl\PencatatanServiceImpl;
use App\Services\PencatatanService;
use Illuminate\Support\ServiceProvider;

class PencatatanProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PencatatanService::class, function($app) {
            $akunRepository = $app->make(AkunRepository::class);
            $transaksiRepository = $app->make(TransaksiRepository::class);

            return new PencatatanServiceImpl($akunRepository, $transaksiRepository);
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
