<?php

namespace App\Providers;

use App\Repositories\AkunRepository;
use App\Repositories\Impl\AkunRepositoryImpl;
use App\Repositories\JenisPembayaranRepository;
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
