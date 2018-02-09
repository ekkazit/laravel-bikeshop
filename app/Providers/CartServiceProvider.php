<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;

class CartServiceProvider extends ServiceProvider
{

    public function boot()
    {
    }

    public function register()
    {
        App::bind('App\Helpers\Cart', function() {
            return new \App\Helpers\Cart;
        });
    }
}
