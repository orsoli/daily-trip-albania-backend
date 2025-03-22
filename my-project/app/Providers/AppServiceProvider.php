<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * Register a custom Blade directive for formatting time.
         */
        Blade::directive('formatTime', function ($time) {
            return  \App\Helpers\DateTimeHelper::formatTime($time);
});
}
}