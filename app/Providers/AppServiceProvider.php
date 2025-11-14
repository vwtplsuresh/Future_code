<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Time;
use App\Observers\TimeObserver;

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
       Time::observe(TimeObserver::class);
    }
}
