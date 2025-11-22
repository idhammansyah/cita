@php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

/* ============================================================
* 0. Ambil user + role
* ============================================================
*/
$user = Auth::user();
$roleId = $user->role_id ?? null;

if (!$roleId) {
echo '<li class="nav-item"><span class="nav-link text-danger">Role tidak ditemukan!</span></li>';
return;
}

$superAdminRoleId = 1;

/* ============================================================
* 1. Ambil menu berdasarkan role
* ============================================================
*/
if ($roleId == $superAdminRoleId) {

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
* 2. Build tree menu
* ============================================================
*/
$menuTree = [];
foreach ($menus as $m) {
if ($m['id_parent'] == $m['id_menus']) continue;
$menuTree[$m['id_parent'] ?? 0][] = $m;
}

$startParent = $menuTree[0] ?? array_key_first($menuTree);
$currentUrl = trim(request()->path(), '/');

/* ============================================================
* 3. Fungsi cek recursive descendant active
* ============================================================
*/
function hasActiveDescendant($menuTree, $menuId, $currentUrl) {
if (!isset($menuTree[$menuId])) return false;

foreach ($menuTree[$menuId] as $child) {

if ($currentUrl === trim($child['url_link'], '/'))
return true;

if (hasActiveDescendant($menuTree, $child['id_menus'], $currentUrl))
return true;
}
return false;
}

/* ============================================================
* 4. Recursive renderer
* ============================================================
*/
function renderMenuItems($menuTree, $parentId, $currentUrl, $depth = 0, $maxDepth = 20, $lastCategory = null)
{
if (!isset($menuTree[$parentId]) || $depth >= $maxDepth) return '';

$padding = $depth * 10;
$output = '<ul class="nav-content">';

  foreach ($menuTree[$parentId] as $menu) {

  $menuId = $menu['id_menus'];
  $menuUrl = url($menu['url_link']);
  $hasChildren = isset($menuTree[$menuId]);

  $isActiveExact = ($currentUrl === trim($menu['url_link'], '/'));
  $isDescActive = hasActiveDescendant($menuTree, $menuId, $currentUrl);

  $activeClass = $isActiveExact ? 'active' : '';
  $showClass = $isDescActive ? 'show' : '';
  $collapseClass = $isDescActive ? '' : 'collapsed';

  /* Kategori (depth 0 only) */
  if ($depth == 0 && !empty($menu['nama_kategori']) && $menu['nama_kategori'] !== $lastCategory) {

  $output .= '<li class="nav-heading">'.e($menu['nama_kategori']).'</li>';

  if (!empty($menu['deskripsi_menu'])) {
  $output .= '<small class="text-muted ms-3" style="font-size:8pt;">'
    .e($menu['deskripsi_menu'])
    .'</small>';
  }

  $lastCategory = $menu['nama_kategori'];
  }

  /* PARENT */
  if ($hasChildren) {

  $output .= '<li class="nav-item">';
    $output .= '<a class="nav-link '.$collapseClass.'" data-bs-target="#menu-'.$menuId.'" data-bs-toggle="collapse"
      href="#">
      <i class="'.$menu['class'].'" style="font-size:12pt; padding-left: '.$padding.'px;"></i>
      <span>'.e($menu['nama_menu']).'</span>
      <i class="bi bi-chevron-down ms-auto" style="font-size:12pt;"></i>
    </a>';

    $output .= '<ul id="menu-'.$menuId.'" class="nav-content collapse '.$showClass.'">';
      $output .= renderMenuItems($menuTree, $menuId, $currentUrl, $depth + 1, $maxDepth, $lastCategory);
      $output .= '</ul>';

    $output .= '</li>';

  } else {
  /* LEAF */
  $output .= '<li class="nav-item">';
    $output .= '<a class="nav-link '.$activeClass.'" href="'.$menuUrl.'">
      <i class="'.$menu['class'].'" style="font-size:12pt; padding-left: '.$padding.'px;"></i>
      <span>'.e($menu['nama_menu']).'</span>
    </a>';
    $output .= '</li>';
  }
  }

  return $output.'</ul>';
}

@endphp

<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">
    {!! renderMenuItems($menuTree, 0, $currentUrl) !!}
  </ul>
</aside>
