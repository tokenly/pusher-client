<?php

namespace Tokenly\PusherClient\Provider;

use Exception;
use Illuminate\Support\ServiceProvider;

/*
* PusherClientServiceProvider
*/
class PusherClientServiceProvider extends ServiceProvider
{

    public function boot()
    {
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->package('tokenly/pusher-client', 'pusher-client', __DIR__.'/../../');

        $this->app->bind('Nc\FayeClient\Client', function($app) {
            $client = new \Nc\FayeClient\Client(new \Nc\FayeClient\Adapter\CurlAdapter(), $app['config']['pusher.serverUrl'].'/public');
            return $client;
        });

        $this->app->bind('Tokenly\PusherClient\PusherClient', function($app) {
            $client = new \Tokenly\PusherClient\Client($app->make('Nc\FayeClient\Client'), $app['config']['pusher.password']);
            return $client;
        });
    }

}

