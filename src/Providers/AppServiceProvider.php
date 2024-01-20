<?php

namespace EscireOrlab\Connect\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;
use EscireOrlab\Connect\Http\Middleware\CheckConnectStatus;
use EscireOrlab\Connect\Console\Commands\GenerateEncryptionKey;

class AppServiceProvider extends ServiceProvider
{

    public function register()
    {
        
        $this->mergeConfigFrom(__DIR__ . '/../../config/orlab-connect.php', 'orlab-connect');

    }

    public function boot(Kernel $kernel)
    {
        $kernel->appendMiddlewareToGroup('web', CheckConnectStatus::class);

        $this->commands([
            GenerateEncryptionKey::class
        ]);
        
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        // $this->loadViewsFrom(__DIR__.'/../../resources/views', 'escireorlabconnect');

        if ($this->app->runningInConsole()) {
            
            // $this->publishes([__DIR__.'/../../resources/views' => resource_path('views/vendor/escireorlabconnect'),], 'views');

            // $this->publishes([__DIR__.'/../../config/escireorlabconnect.php' => config_path('escireorlabconnect.php')], 'config');

        }

    }
    
}