<?php

namespace Tokenly\PusherClient\Provider;

use Exception;
use Illuminate\Support\Facades\Config;
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
        $this->bindConfig();

        $this->app->bind('Nc\FayeClient\Client', function($app) {
            $client = new \Nc\FayeClient\Client(new \Nc\FayeClient\Adapter\CurlAdapter(), Config::get('tokenlyPusher.serverUrl').'/public');
            return $client;
        });

        $this->app->bind('Tokenly\PusherClient\Client', function($app) {
            $client = new \Tokenly\PusherClient\Client($app->make('Nc\FayeClient\Client'), Config::get('tokenlyPusher.password'));
            return $client;
        });
    }

    protected function bindConfig() {
        // simple config
        $config = [
            'tokenlyPusher.serverUrl' => getenv('PUSHER_SERVER_URL') ?: 'http://localhost:8000',
            'tokenlyPusher.password'  => getenv('PUSHER_PASSWORD')   ?: null,
        ];

        // set the laravel config
        Config::set($config);

        return $config;
    }



}

