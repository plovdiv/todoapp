<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Service providers are auto-discovered by Laravel from version 5.5
         * If a Service Provider is needed only is specific environment
         * use the switch below
         */
        switch ($this->app->environment()) {
            case 'local':
                $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
                break;

            case 'test':
                break;

            case 'staging':
                break;

            case 'production':
                break;
        }
    }

}
