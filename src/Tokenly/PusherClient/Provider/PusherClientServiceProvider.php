<?php

namespace Tokenly\PusherClient\Provider;

use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

/*
* PusherClientServiceProvider for Laravel 5
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
        $server_url = env('PUSHER_SERVER_URL') ?: 'http://pusher.dev01.tokenly.co';

        $config = [
            'tokenlyPusher.serverUrl' => $server_url,
            'tokenlyPusher.clientUrl' => env('PUSHER_CLIENT_URL', $server_url),
            'tokenlyPusher.password'  => env('PUSHER_PASSWORD', null),
        ];

        // set the laravel config
        Config::set($config);

        return $config;
    }



}

