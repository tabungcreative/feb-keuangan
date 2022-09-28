<?php

namespace App\Providers;

use App\Repositories\Impl\TransaksiRepositoryImpl;
use App\Repositories\TransaksiRepository;
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
