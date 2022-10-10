<?php

namespace App\Providers;

use App\Repositories\AktivaRepository;
use App\Repositories\Impl\AktivaRepositoryImpl;
use App\Services\AktivaService;
use App\Services\Impl\AktivaServiceImpl;
use Illuminate\Support\ServiceProvider;

class AktivaProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton(AktivaRepository::class, AktivaRepositoryImpl::class);
        $this->app->singleton(AktivaService::class, function ($app) {
            $aktivaRepository = $app->make(AktivaRepository::class);
            return new AktivaServiceImpl($aktivaRepository);
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
