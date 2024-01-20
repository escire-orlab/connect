<?php

namespace EscireOrlab\Connect\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register()
    {
        
        // $this->mergeConfigFrom(__DIR__ . '/../../config/escireorlabconnect.php', 'escireorlabconnect');

    }

    public function boot()
    {
        
        // $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        // $this->loadViewsFrom(__DIR__.'/../../resources/views', 'escireorlabconnect');

        if ($this->app->runningInConsole()) {
            
            // $this->publishes([__DIR__.'/../../resources/views' => resource_path('views/vendor/escireorlabconnect'),], 'views');

            // $this->publishes([__DIR__.'/../../config/escireorlabconnect.php' => config_path('escireorlabconnect.php')], 'config');

        }

    }
    
}