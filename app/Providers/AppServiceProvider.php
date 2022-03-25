<?php

namespace App\Providers;
use App\Models\AccessPointStatistic;
use Illuminate\Support\ServiceProvider;

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
        AccessPointStatistic::observe(AccessPointStatisticObserver::class);

        //
    }
}
