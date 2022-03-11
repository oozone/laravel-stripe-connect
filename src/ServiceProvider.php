<?php

namespace SimonHamp\LaravelStripeConnect;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use SimonHamp\LaravelStripeConnect\Interfaces\StripeConnect as StripeConnectInterface;
use Stripe\StripeClient;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/../migrations');
        $this->mergeConfigFrom(__DIR__.'/../config/stripe_connect.php', 'stripe_connect');
        $this->publishes([__DIR__.'/../config', __DIR__.'/../migrations']);
    }

    public function register()
    {
        App::singleton(StripeConnectInterface::class, function () {
            return new StripeClient(Config::get('stripe_connect.stripe.secret'));
        });
    }
}