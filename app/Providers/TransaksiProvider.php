<?php

namespace App\Providers;

use App\Repositories\AkunRepository;
use App\Repositories\Impl\TransaksiRepositoryImpl;
use App\Repositories\TransaksiRepository;
use App\Services\Impl\TransaksiServiceImpl;
use App\Services\TransaksiService;
use Illuminate\Support\ServiceProvider;

class TransaksiProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TransaksiRepository::class, TransaksiRepositoryImpl::class);
        $this->app->singleton(TransaksiService::class, function ($app) {
            $transaksiRepository = $app->make(TransaksiRepository::class);
            $akunRepository = $app->make(AkunRepository::class);

            return new TransaksiServiceImpl($transaksiRepository, $akunRepository);
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
