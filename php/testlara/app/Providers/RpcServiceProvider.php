<?php

namespace App\Providers;

use app\Service\RpcxService;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class RpcServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(RpcxService::class,function (Application $app) {
            return new RpcxService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
