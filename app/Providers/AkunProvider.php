<?php

namespace App\Providers;

use App\Repositories\AkunRepository;
use App\Repositories\Impl\AkunRepositoryImpl;
use App\Repositories\JenisPembayaranRepository;
use App\Services\AkunService;
use App\Services\Impl\AkunServiceImpl;
use Illuminate\Support\ServiceProvider;

class AkunProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton(AkunRepository::class, AkunRepositoryImpl::class);
        $this->app->singleton(AkunService::class, function ($app) {
            $akunRepository = $app->make(AkunRepository::class);
            return new AkunServiceImpl($akunRepository);
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
