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
        // if ($this->app->isLocal()) {
        // //if local register your services you require for development
        //     $this->app->register(__L);
        // } else {
        // //else register your services you require for production
        //     $this->app['request']->server->set('HTTPS', true);
        // }
    }
    //check that app is local

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
