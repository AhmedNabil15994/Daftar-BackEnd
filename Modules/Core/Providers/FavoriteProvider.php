<?php

namespace Modules\Core\Providers;

use Darryldecode\Cart\Cart;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class FavoriteProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('favorite', function($app)
        {
            $storage      = $app['session'];
            $events       = $app['events'];
            $instanceName = 'cart_2';
            $session_key  = '88uuiioo99888';

            return new Cart(
                $storage,
                $events,
                $instanceName,
                $session_key,
                config('shopping_cart')
            );
        });
    }
}
