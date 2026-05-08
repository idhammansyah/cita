<?php

namespace App\Providers;

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
    public function boot()
    {
      \Carbon\Carbon::setLocale('id');
      config(['app.locale' => 'id']);
      setlocale(LC_TIME, 'id_ID.utf8');
    }
}
