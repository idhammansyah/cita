<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckingRole
{

  public function handle($request, Closure $next, ...$roles)
  {
    $user = Auth::user();

    // Convert each role param like "1,2" into ["1","2"]
    $parsedRoles = [];

    foreach ($roles as $r) {
        foreach (explode(',', $r) as $value) {
            $parsedRoles[] = trim($value);
        }
    }

    if (!in_array($user->role_id, $parsedRoles)) {
        abort(403, 'Unauthorized');
    }

    return $next($request);
  }

}
