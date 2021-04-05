<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //$this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
}
