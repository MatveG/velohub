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
        try {
            App\Views\Directives\WidgetDirective::directives();
            App\Views\Share\CategoryTreeShare::share();
            App\Views\Share\MenuTreeShare::share();
        }  catch (\Exception $e) {
            // do nothing
        }
    }
}
