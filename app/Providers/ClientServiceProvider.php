<?php

namespace App\Providers;

use App\Services\Client\ClientRegistry;
use App\Services\Client\Format\ClientJSON;
use App\Services\Client\Format\ClientSOAP;
use Illuminate\Support\ServiceProvider;

class ClientServiceProvider extends ServiceProvider
{
    protected $listen = [
        'json' =>  ClientJSON::class,
        'xml'  =>  ClientSOAP::class
    ];

    function register()
    {
        $this->app->singleton(ClientRegistry::class);
    }

    function boot()
    {
        $app = $this->app->make(ClientRegistry::class);

        foreach ($this->listen as $event => $listener) {
            $app->register($event, $this->app->make($listener));
        }
    }
}
