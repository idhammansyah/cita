@php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

$user = Auth::user();
$roleId = $user->role_id ?? null;

if (!$roleId) {
  echo '<li class="nav-item"><span class="nav-link text-danger">Role tidak ditemukan!</span></li>';
  return;
}

$superAdminRoleId = 1; // Ubah sesuai database kamu

/* ============================================================
 * 1. Ambil menu berdasarkan role
 * ============================================================
*/
if ($roleId == $superAdminRoleId) {

    // SUPERADMIN → semua module + menu
  $menus = DB::select("
      SELECT
          m.id_menus, m.nama_menu, m.url_link, m.class,
          m.id_parent, m.urutan, m.posisi, m.is_active,
          mk.nama_kategori, mk.deskripsi_menu,
          md.id_modules, md.nama_modules, md.login
      FROM menus m
      JOIN menus_kategori mk ON m.id_menu_kategori = mk.id_menu_kategori
      JOIN modules md ON md.id_modules = m.id_modules
      WHERE m.is_active = 1
        AND m.posisi = 'sidebar'
        AND md.login = 1
        AND md.is_deleted = 0
      ORDER BY mk.urutan, m.id_parent, m.urutan ASC
  ");

} else {

    // ROLE BIASA → harus lolos module_roles.can_read + menu_roles
    // $menus = DB::select("
    //   SELECT DISTINCT
    //       m.id_menus, m.nama_menu, m.url_link, m.class,
    //       m.id_parent, m.urutan, m.posisi, m.is_active,

    //       mk.nama_kategori, mk.deskripsi_menu,
    //       mk.urutan AS kategori_urutan,

    //       md.id_modules, md.nama_modules, md.login,

    //       mr.`can_read`
    //   FROM module_roles mr
    //   JOIN modules md
    //       ON md.id_modules = mr.id_module
    //     AND mr.id_role = ?
    //     AND mr.can_read = 1
    //     AND md.is_deleted = 0
    //   JOIN menus m
    //       ON m.id_modules = md.id_modules
    //     AND m.is_active = 1
    //     AND m.posisi = 'sidebar'
    //   JOIN menus_kategori mk
    //       ON mk.id_menu_kategori = m.id_menu_kategori
    //   JOIN menu_roles mnr
    //       ON mnr.id_menus = m.id_menus
    //     AND mnr.id_roles = ?
    //   WHERE md.login = 1
    //   ORDER BY mk.urutan, m.id_parent, m.urutan ASC
    // ", [$roleId, $roleId]);
   $menus = DB::select("
    SELECT DISTINCT
        m.id_menus, m.nama_menu, m.url_link, m.class,
        m.id_parent, m.urutan, m.posisi, m.is_active,
        mk.nama_kategori, mk.deskripsi_menu, mk.urutan AS kategori_urutan,
        md.id_modules, md.nama_modules, md.login,
        mr.can_read
    FROM module_roles mr
    JOIN modules md
        ON md.id_modules = mr.id_module
       AND mr.id_role = ?
       AND mr.can_read = 1
       AND md.is_deleted = 0
    JOIN menus m
        ON m.id_modules = md.id_modules
       AND m.is_active = 1
       AND m.posisi = 'sidebar'
    JOIN menus_kategori mk
        ON mk.id_menu_kategori = m.id_menu_kategori
    JOIN menu_roles mnr
        ON mnr.id_menus = m.id_menus
       AND mnr.id_roles = ?
    WHERE md.login = 1
    ORDER BY mk.urutan, m.id_parent, m.urutan ASC
", [$roleId, $roleId]);

}

$menus = json_decode(json_encode($menus), true);


/* ============================================================
 * 2. Build Menu Tree
 * ============================================================
*/
$menuTree = [];
foreach ($menus as $menu) {
    if ($menu['id_parent'] == $menu['id_menus']) continue;
    $menuTree[$menu['id_parent'] ?? 0][] = $menu;
}

$startParent = isset($menuTree[0]) ? 0 : array_key_first($menuTree);
$currentUrl = request()->path();


/* ============================================================
 * 3. Recursive Renderer (kategori + deskripsi kategori + deskripsi menu)
 * ============================================================
*/
function renderMenuItems($menuTree, $parentId, $currentUrl, $depth = 0, $maxDepth = 10, $lastCategory = null)
{
    if (!isset($menuTree[$parentId]) || $depth >= $maxDepth) return '';

    $output = '<ul class="nav-content">';

    foreach ($menuTree[$parentId] as $menu) {

        $menuId      = $menu['id_menus'];
        $menuUrl     = url($menu['url_link']);
        $hasChildren = isset($menuTree[$menuId]);
        $isActive    = ($currentUrl == $menu['url_link']) ? 'active' : '';

        /* ============================================================
         * Tampilkan kategori & deskripsi kategori 1x saja di depth=0
         * ============================================================
        */
        if ($depth == 0 && !empty($menu['nama_kategori']) && $menu['nama_kategori'] !== $lastCategory) {

            // Nama kategori
            $output .= '<li class="nav-heading">'.e($menu['nama_kategori']).'</li>';

            // Deskripsi kategori
            if (!empty($menu['deskripsi_menu'])) {
                $output .= '<small class="text-muted ms-3" style="font-size:8pt;">'.e($menu['deskripsi_menu']).'</small>';
            }

            $lastCategory = $menu['nama_kategori'];
        }

        /* ============================================================
         * Cek parent active (expand menu)
         * ============================================================
        */
        $isParentActive = false;
        if ($hasChildren) {
            foreach ($menuTree[$menuId] as $child) {
                if ($currentUrl == $child['url_link']) {
                    $isParentActive = true;
                    break;
                }
            }
        }

        /* ============================================================
         * MENU DENGAN CHILD
         * ============================================================
        */
        if ($hasChildren) {

            $output .= '<li class="nav-item">';
            $output .= '<a class="nav-link collapsed"
                          data-bs-target="#menu-'.$menuId.'"
                          data-bs-toggle="collapse"
                          href="#">';

            $output .= '<i class="'.e($menu['class']).'" style="font-size:12pt;"></i>';
            $output .= '<span>'.e($menu['nama_menu']).'</span>';
            $output .= '<i class="bi bi-chevron-down ms-auto" style="font-size:12pt;"></i>';

            $output .= '</a>';

            $output .= '<ul id="menu-'.$menuId.'" class="nav-content collapse '.($isParentActive ? "show" : "").'">';
            $output .= renderMenuItems($menuTree, $menuId, $currentUrl, $depth + 1, $maxDepth, $lastCategory);
            $output .= '</ul>';

            $output .= '</li>';

        } else {

        /* ============================================================
         * MENU TANPA CHILD — tampilkan deskripsi menu
         * ============================================================
        */
            $output .= '<li class="nav-item">';
            $output .= '<a class="nav-link '.$isActive.'" href="'.$menuUrl.'">';

            $output .= '<i class="'.e($menu['class']).'" style="font-size:12pt;"></i>';
            $output .= '<span>'.e($menu['nama_menu']).'</span>';

            $output .= '</a>';
            $output .= '</li>';
        }
    }

    $output .= '</ul>';
    return $output;
}
@endphp


{{-- ======================================================
    4. OUTPUT SIDEBAR
   ====================================================== --}}
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        {!! renderMenuItems($menuTree, $startParent, $currentUrl) !!}
    </ul>
</aside>
