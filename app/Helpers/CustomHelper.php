<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reimbursement\ReimbursementLog;

if (!function_exists('renderBreadcrumb')) {
    function renderBreadcrumb()
    {
        $currentUrl = Request::path(); // Ambil URL saat ini
        $menu = DB::table('menus')->where('url_link', $currentUrl)->first();

        if (!$menu) {
            return ''; // Jika menu tidak ditemukan, tidak tampilkan breadcrumb
        }

        $breadcrumbs = [];

        while ($menu) {
            $breadcrumbs[] = [
                'nama_menu' => $menu->nama_menu,
                'url_link' => ($menu->id_parent == 0) ? url($menu->url_link) : null
            ];

            if ($menu->id_parent != 0) {
                $menu = DB::table('menus')->where('id_menus', $menu->id_parent)->first();
            } else {
                $menu = null;
            }
        }

        $breadcrumbs = array_reverse($breadcrumbs);

        // Generate HTML breadcrumb
        $html = '<nav><ol class="breadcrumb">';
        $html .= '<li class="breadcrumb-item"><a href="' . url('dashboard') . '">Dashboard</a></li>';

        foreach ($breadcrumbs as $breadcrumb) {
            if ($breadcrumb['url_link']) {
                $html .= '<li class="breadcrumb-item"><a href="' . $breadcrumb['url_link'] . '">' . e($breadcrumb['nama_menu']) . '</a></li>';
            } else {
                $html .= '<li class="breadcrumb-item active">' . e($breadcrumb['nama_menu']) . '</li>';
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
