<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
  public function boot(): void
  {
    // route default
    Route::middleware('web')->group(base_path('routes/web.php'));

    // route API default
    Route::middleware('api')->prefix('api')->group(base_path('routes/api.php'));

    // route khusus role 3 (user)
    Route::middleware('web')
      ->prefix('user')
      ->name('user.')
      ->group(base_path('routes/user.php'));
  }
}
