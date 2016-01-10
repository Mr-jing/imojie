<?php

namespace Imojie\Providers;

use Dingo\Api\Auth\Auth;
use Dingo\Api\Auth\Provider\OAuth2;
use Illuminate\Support\ServiceProvider;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class OAuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app[Auth::class]->extend('oauth', function ($app) {
            $provider = new OAuth2($app['oauth2-server.authorizer']->getChecker());

            $provider->setUserResolver(function ($id) {
                return Sentinel::findById($id);
            });

            $provider->setClientResolver(function ($id) {
                // Logic to return a client by their ID.
            });

            return $provider;
        });
    }

    public function register()
    {
        //
    }
}