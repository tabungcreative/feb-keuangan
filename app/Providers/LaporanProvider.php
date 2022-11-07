<?php

namespace App\Providers;

use App\Services\Impl\LaporanServiceImpl;
use App\Services\LaporanService;
use Illuminate\Support\ServiceProvider;

class LaporanProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(LaporanService::class, LaporanServiceImpl::class);
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
