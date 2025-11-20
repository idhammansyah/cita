<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class PermissionBladeServiceProvider extends ServiceProvider
{
  public function boot()
  {
      Blade::directive('canCreate', fn() => "<?php if(canAccess('create')): ?>");
      Blade::directive('endcanCreate', fn() => "<?php endif; ?>");

      Blade::directive('canUpdate', fn() => "<?php if(canAccess('update')): ?>");
      Blade::directive('endcanUpdate', fn() => "<?php endif; ?>");

      Blade::directive('canDelete', fn() => "<?php if(canAccess('delete')): ?>");
      Blade::directive('endcanDelete', fn() => "<?php endif; ?>");

      Blade::directive('canRead', fn() => "<?php if(canAccess('read')): ?>");
      Blade::directive('endcanRead', fn() => "<?php endif; ?>");
  }
}
