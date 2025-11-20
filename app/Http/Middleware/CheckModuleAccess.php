<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckModuleAccess
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $roleId = $user->role_id;
        $superAdminRoleId = 1; // sesuaikan role superadmin

        // Jika superadmin → bypass
        if ($roleId == $superAdminRoleId) {
          return $next($request);
        }

        // Cari menu berdasarkan URL saat ini
        $currentUrl = $request->path();

        $menu = DB::table('menus')
            ->whereRaw("TRIM(LEADING '/' FROM url_link) = ?", [$currentUrl])
            ->where('is_active', 1)
            ->first();

        // Jika menu tidak ditemukan → anggap tidak ada route
        if (!$menu) {
          abort(404);
        }

        // Cek module di menu
        $moduleId = $menu->id_modules;

        $moduleRole = DB::table('module_roles')
          ->where('id_module', $moduleId)
          ->where('id_role', $roleId)
          ->first();

        // Jika module belum diberikan akses → 403
        if (!$moduleRole || $moduleRole->can_read == 0) {
            abort(403, 'Forbidden');
        }

        return $next($request);
    }
}
