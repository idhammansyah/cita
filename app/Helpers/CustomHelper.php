<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reimbursement\ReimbursementLog;

if (!function_exists('renderBreadcrumb')) {
    function renderBreadcrumb()
    {
        $current = Request::path();
        $fullUrl = url()->current();
        $withSlash = "/" . ltrim($current, "/");

        // 1. Coba cari menu berdasarkan 3 kemungkinan URL
        $menu = DB::table('menus')
            ->where('url_link', $current)
            ->orWhere('url_link', $withSlash)
            ->orWhere('url_link', $fullUrl)
            ->first();

        // 2. Fallback: cari LIKE (misal /user/edit/5)
        if (!$menu) {
            $menu = DB::table('menus')
                ->where('url_link', 'LIKE', $current . '%')
                ->orWhere('url_link', 'LIKE', $withSlash . '%')
                ->first();
        }

        // Jika tetap tidak ditemukan → kosongkan breadcrumb
        if (!$menu) {
            return '';
        }

        $breadcrumbs = [];
        $visited = [];

        // 3. Loop parent
        while ($menu) {

            if (in_array($menu->id_menus, $visited)) {
                break; // cegah infinite loop
            }
            $visited[] = $menu->id_menus;

            $breadcrumbs[] = [
                'nama_menu' => $menu->nama_menu,
                'url_link' => $menu->url_link ? url($menu->url_link) : null
            ];

            // STOP jika root
            if ($menu->id_parent == 0 || $menu->id_parent == $menu->id_menus) {
                break;
            }

            $menu = DB::table('menus')->where('id_menus', $menu->id_parent)->first();
        }

        // Balikkan (root → child)
        $breadcrumbs = array_reverse($breadcrumbs);

        // 4. Render HTML
        $html = '<nav><ol class="breadcrumb">';
        $html .= '<li class="breadcrumb-item"><a href="' . url('dashboard') . '">Dashboard</a></li>';

        foreach ($breadcrumbs as $i => $crumb) {
            $last = ($i === array_key_last($breadcrumbs));

            if ($crumb['url_link'] && !$last) {
                $html .= '<li class="breadcrumb-item"><a href="' . $crumb['url_link'] . '">'
                        . e($crumb['nama_menu']) . '</a></li>';
            } else {
                $html .= '<li class="breadcrumb-item active" aria-current="page">'
                        . e($crumb['nama_menu']) . '</li>';
            }
        }

        $html .= '</ol></nav>';

        return $html;
    }
}

if (!function_exists('getUserData')) {
    function getUserData()
    {
        if (!Auth::check()) {
            return null;
        }

        return DB::table('users')
            ->join('roles', 'roles.id_roles', '=', 'users.role_id')
            ->where('users.id', Auth::id())
            ->select('users.full_name', 'users.photo_profile', 'users.role_id', 'roles.nama_roles', 'roles.id_roles')
            ->first();
    }
}

if (!function_exists('getMenus')) {
    function getMenus()
    {
        if (!Auth::check()) {
            return [];
        }

        return DB::table('menus')
            ->join('menu_roles', 'menu_roles.id_menus', '=', 'menus.id_menus')
            ->where('menus.posisi', 'navbar')
            ->where('menu_roles.id_roles', Auth::user()->role_id)
            ->get();
    }

  if (!function_exists('flash_message')) {
    function flash_message()
    {
        if (session('success')) {
            return '<div class="alert alert-success alert-dismissible fade show" role="alert">'
                . session('success') .
                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }

        if (session('error')) {
            return '<div class="alert alert-danger alert-dismissible fade show" role="alert">'
                . session('error') .
                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }

        return '';
    }
  }
}

function logReimbursementActivity($reimbursement_id, $action, $desc = null)
{
    ReimbursementLog::create([
      'reimbursement_id' => $reimbursement_id,
      'user_id' => Auth::user()->id,
      'action' => $action,
      'description' => $desc,
    ]);
}

if (!function_exists('currentModuleId')) {
    function currentModuleId()
    {
        $url = '/' . ltrim(Request::path(), '/');  // pastikan format "/dashboard"

        $menu = DB::table('menus')
            ->where('url_link', $url)
            ->where('is_active', 1)
            ->first();

        return $menu->id_modules ?? null;
    }
}

if (!function_exists('canAccess')) {
    function canAccess($permission)
    {
        $user = Auth::user();
        if (!$user) return false;

        $roleId = $user->role_id ?? null;
        if (!$roleId) return false;

        // SUPERADMIN
        if ($roleId == 1) return true;

        $moduleId = currentModuleId();
        if (!$moduleId) return false;

        $moduleRole = DB::table('module_roles')
            ->where('id_role', $roleId)
            ->where('id_module', $moduleId)
            ->first();

        if (!$moduleRole) return false;

        return match ($permission) {
            'read'   => $moduleRole->can_read == 1,
            'create' => $moduleRole->can_create == 1,
            'update' => $moduleRole->can_update == 1,
            'delete' => $moduleRole->can_delete == 1,
            default  => false,
        };
    }
}


