<?php

namespace App\Providers;

use App;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        App\Views\Directives\WidgetDirectives::directives();

        App\Views\Share\CartShare::share();
        App\Views\Share\CategoryShare::share();
        App\Views\Share\MenuShare::share();
    }
}
