@php
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Auth;

    $user = Auth::user();
    $roleId = $user->role_id ?? null;

    if (!$roleId) {
        echo '<li class="nav-item"><span class="nav-link text-danger">Role ID tidak ditemukan!</span></li>';
        return;
    }

    $menus = DB::select(
        "SELECT DISTINCT
            m.id_menus, m.nama_menu, m.url_link, m.class, m.id_parent, m.urutan,
            mk.nama_kategori, mk.deskripsi_menu, md.id_modules, md.login
        FROM menus m
        JOIN menu_roles mr ON m.id_menus = mr.id_menus
        JOIN menus_kategori mk ON m.id_menu_kategori = mk.id_menu_kategori
        JOIN modules md ON md.id_modules = m.id_modules
        WHERE md.login = ? AND m.is_active = 1
            AND m.posisi = 'sidebar'
            AND md.id_modules IS NOT NULL
            AND mr.id_roles = ?
        ORDER BY m.id_parent, m.urutan ASC",
        [$user ? 1 : 0, $roleId]
    );

    $menus = json_decode(json_encode($menus), true);

    $menuTree = [];
    foreach ($menus as $menu) {
        if ($menu['id_parent'] == $menu['id_menus']) continue;
        $parentId = $menu['id_parent'] ?? 0;
        $menuTree[$parentId][] = $menu;
    }

    $startParent = isset($menuTree[0]) ? 0 : array_key_first($menuTree);
    $currentUrl = request()->path();

    function renderMenuItems($menuTree, $parentId, $currentUrl, $depth = 0, $maxDepth = 10) {
        if (!isset($menuTree[$parentId]) || $depth >= $maxDepth) {
            return '';
        }

        $output = '<ul class="nav-content">';
        foreach ($menuTree[$parentId] as $menu) {
            $menuId = $menu['id_menus'];
            $menuUrl = url($menu['url_link']);
            $hasChildren = isset($menuTree[$menuId]);
            $isActive = ($currentUrl == $menu['url_link']) ? 'active' : '';
            $isParentActive = false;
            if ($hasChildren) {
                foreach ($menuTree[$menuId] as $child) {
                    if ($currentUrl == $child['url_link']) {
                        $isParentActive = true;
                        break;
                    }
                }
            }

            if ($hasChildren) {
                $output .= '<li class="nav-heading">' . e($menu['nama_kategori']) . '</li>';
                // $output .= '<span class="nav-heading">' . e($menu['deskripsi_menu']) . '</span>';
                $output .= '<li class="nav-item">';
                $output .= '<a class="nav-link collapsed" data-bs-target="#menu-' . $menuId . '" data-bs-toggle="collapse" href="#">';
                $output .= '<i style="font-size:12pt;" class="' . e($menu['class']) . '"></i>';
                $output .= '<span>' . e($menu['nama_menu']) . '</span>';
                $output .= '<i style="font-size:12pt;" class="bi bi-chevron-down ms-auto"></i>';
                $output .= '</a>';
                $output .= '<ul id="menu-' . $menuId . '" class="nav-content collapse ' . ($isParentActive ? 'show' : '') . '" data-bs-parent="#sidebar-nav">';
                $output .= renderMenuItems($menuTree, $menuId, $currentUrl, $depth + 1, $maxDepth);
                $output .= '</ul>';
                $output .= '</li>';
            } else {
                $output .= '<li class="nav-item">';
                $output .= '<a class="nav-link ' . $isActive . '" href="' . $menuUrl . '">';
                $output .= '<i style="font-size:12pt;" class="' . e($menu['class']) . '"></i>';
                $output .= '<span>' . e($menu['nama_menu']) . '</span>';
                $output .= '</a>';
                $output .= '</li>';
            }
        }
        $output .= '</ul>';
        return $output;
    }
@endphp

<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        {!! renderMenuItems($menuTree, $startParent, $currentUrl) !!}
    </ul>
</aside>
