<?php

namespace App\Providers;

use App\Models\UserPending;
use App\Models\User;
use App\Observers\UserObserver;
use App\Observers\UserRegisterObserver;
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
        User::observe(UserObserver::class);
        UserPending::observe(UserRegisterObserver::class);
    }
}
