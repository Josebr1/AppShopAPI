<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Configuraçoes iniciais do pagseguro
         */
        \PagSeguroLibrary::init();
        \PagSeguroConfig::init();
        \PagSeguroResources::init();
    }
}
