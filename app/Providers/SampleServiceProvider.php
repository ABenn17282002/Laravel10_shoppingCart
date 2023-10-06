<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SampleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // サービスプロバイダーの登録
        app()->bind('ServiceProviderTest',function(){
            return 'サービスプロバイダー';
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
