<?php

namespace EscireOrlab\Connect\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{

    public function map()
    {

        $this->mapRoutes();      

    }

    protected function mapRoutes()
    {

        Route::middleware('web')
            ->prefix('orlab/connect/')
            ->as('orlab.connect.')
            ->namespace('EscireOrlab\Connect\Http\Controllers')
            ->group(__DIR__ . '/../../routes/web.php');
        
        Route::middleware('api')
            ->prefix('orlab/connect/')
            ->as('orlab.connect.')
            ->namespace('EscireOrlab\Connect\Http\Controllers')
            ->group(__DIR__ . '/../../routes/api.php');

    }

}
