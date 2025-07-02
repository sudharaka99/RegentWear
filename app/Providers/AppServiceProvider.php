<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Use Bootstrap for pagination
        Paginator::useBootstrapFive();

        // Optionally, you can set the default locale or other configurations here
        // \Carbon\Carbon::setLocale(config('app.locale'));
    }
}
