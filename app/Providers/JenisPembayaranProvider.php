<?php

namespace App\Providers;

use App\Repositories\AkunRepository;
use App\Repositories\Impl\JenisPembayaranRepositoryImpl;
use App\Repositories\JenisPembayaranRepository;
use App\Services\Impl\JenisPembayaranServiceImpl;
use App\Services\JenisPembayaranService;
use Illuminate\Support\ServiceProvider;

class JenisPembayaranProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton(JenisPembayaranRepository::class, JenisPembayaranRepositoryImpl::class);

        $this->app->singleton(JenisPembayaranService::class, function($app) {
            $jenisPembayaranRepository = $app->make(JenisPembayaranRepository::class);
            $akunRepository = $app->make(AkunRepository::class);
            return new JenisPembayaranServiceImpl($jenisPembayaranRepository, $akunRepository);
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
