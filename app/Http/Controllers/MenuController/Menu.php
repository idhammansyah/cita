<?php

namespace App\Http\Controllers\MenuController;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class Menu extends Controller
{
  public function index()
  {
    $roles = DB::table('roles')
    ->where('is_deleted', 0)
    ->orderBy('id_roles')
    ->get();

    $menus = DB::table('roles')
    ->join('module_roles', 'roles.id_roles', '=', 'module_roles.id_role')
    ->join('modules', 'module_roles.id_module', '=', 'modules.id_modules')
    ->join('menus', 'menus.id_modules', '=', 'modules.id_modules')
    ->join('menu_roles', function ($join) {
      $join->on('menus.id_menus', '=', 'menu_roles.id_menus')
      ->on('menu_roles.id_roles', '=', 'roles.id_roles');
    })
    ->join('menus_kategori', 'menus.id_menu_kategori', '=', 'menus_kategori.id_menu_kategori')
    ->select(
      'roles.id_roles',
      'roles.nama_roles',
      'modules.id_modules',
      'modules.nama_modules',
      'menus.id_menus',
      'menus.nama_menu',
      'menus.url_link',
      'menus.class',
      'menus_kategori.nama_kategori',
      'module_roles.can_read',
      'module_roles.can_create',
      'module_roles.can_update',
      'module_roles.can_delete'
    )
    ->orderBy('roles.id_roles')
    ->orderBy('menus_kategori.urutan')
    ->orderBy('menus.urutan')
    ->get();


    $menus_raw = DB::table('menus')->where('is_active', 1)->orderBy('id_parent', 'ASC')->orderBy('urutan', 'ASC')->get();
    $modules = DB::table('modules')->get();
    $menuses = DB::table('menus')
    ->join('menus_kategori', 'menus.id_menu_kategori', '=', 'menus_kategori.id_menu_kategori')
    ->select('menus.*', 'menus_kategori.nama_kategori')
    ->where('menus.is_active', 1)
    ->get();

    $all_menus = DB::table('menus')
      ->where('is_active', 1)
      ->orderBy('nama_menu')
      ->get();

    $permissions = DB::table('roles as r')
    ->join('module_roles as mr', 'r.id_roles', '=', 'mr.id_role')
    ->join('modules as m', 'mr.id_module', '=', 'm.id_modules')
    ->join('menus as mn', 'mn.id_modules', '=', 'm.id_modules')
    ->leftJoin('menus_kategori as mk', 'mn.id_menu_kategori', '=', 'mk.id_menu_kategori')
    ->leftJoin('menu_roles as mnr', function($join) {
        $join->on('mnr.id_menus', '=', 'mn.id_menus')
             ->on('mnr.id_roles', '=', 'r.id_roles');
    })
    ->select(
        'r.id_roles',
        'r.nama_roles',
        'm.id_modules',
        'm.nama_modules',
        'mn.id_menus',
        'mn.nama_menu',
        'mn.url_link',
        'mn.class',
        'mk.nama_kategori',
        'mr.can_read as module_read',
        'mr.can_create as module_create',
        'mr.can_update as module_update',
        'mr.can_delete as module_delete',
        DB::raw('CASE WHEN mnr.id_menus IS NOT NULL THEN 1 ELSE 0 END AS menu_active')
    )
    ->orderBy('r.id_roles')
    ->orderBy('m.id_modules')
    ->orderBy('mn.urutan')
    ->get();

    // Tambahan: ambil semua kategori menu
    $categories = DB::table('menus_kategori')->orderBy('urutan')->get();

    return view('menu_management.index', compact('menus', 'roles', 'menus_raw', 'modules', 'categories', 'all_menus', 'permissions'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'nama_menu' => 'required|string|max:100',
      'id_modules' => 'required|integer',
      'urutan' => 'required|integer',
      // 'is_active' => 'required|boolean',
    ]);

    DB::table('menus')->insert([
      'nama_menu' => $request->nama_menu,
      'id_parent' => $request->id_parent ?? 0,
      'id_modules' => $request->id_modules,
      'url_link' => $request->url_link,
      'class' => $request->class,
      'urutan' => $request->urutan,
      'posisi' => $request->posisi ?? 'sidebar',
      'is_active' => 1,
      'id_menu_kategori' => 1, // default kategori (kalau lo gak pake kategori hapus aja field ini)
    ]);

    return redirect()->back()->with('success', 'Menu berhasil ditambahkan.');
  }

  public function show($id)
  {
    return DB::table('menus')->where('id_menus', $id)->first();
  }

  public function update(Request $request, $id)
  {
    DB::table('menus')->where('id_menus', $id)->update([
      'nama_menu' => $request->nama_menu,
      'url_link' => $request->url_link,
      'class' => $request->class,
    ]);

    return redirect()->route('menu-management')->with('success', 'Menu berhasil diupdate.');
  }

  public function destroy($id)
  {
    DB::table('menus')
        ->where('id_menus', $id)
        ->update(['is_active' => 0]);

    return redirect()->route('menu-management')->with('success', 'Menu berhasil di-nonaktifkan.');
  }

  public function getByCategory($id)
  {
    // 1. Ambil semua menu untuk kategori yang dipilih, diurutkan berdasarkan urutan
    $menus = DB::table('menus')
      ->where('menus.id_menu_kategori', $id)
      ->where('menus.is_active', 1)
      ->orderBy('urutan')
      ->get();

    $nestedMenus = [];
    $menuMap = [];

    foreach ($menus as $menu) {
      $menu->children = [];
      $menuMap[$menu->id_menus] = $menu;
    }

    foreach ($menus as $menu) {
      if ($menu->id_parent == 0 || $menu->id_parent === null) {
        $nestedMenus[] = $menu;
      } else {
        if (isset($menuMap[$menu->id_parent])) {
          $menuMap[$menu->id_parent]->children[] = $menu;
        }
      }
    }

    return response()->json($nestedMenus);
  }

  public function get_menu_by_id($id)
  {
    $menu = DB::table('menus')
      ->where('id_menus', $id)
      ->first();
    return response()->json($menu);
  }

  public function update_menu(Request $request, $id)
  {
    $validator = Validator::make($request->all(), [
      'nama_menu' => 'required|string|max:50',
      'url_link' => 'required|string|max:50',
      'class' => 'nullable|string|max:50',
      // 'id_menu_kategori' => 'required|integer', // Sesuaikan jika ini juga diubah
      // 'id_modules' => 'required|integer', // Sesuaikan jika ini juga diubah
      // 'posisi' => 'required|string|max:50', // Sesuaikan jika ini juga diubah
      'id_parent' => 'nullable|integer',
      'urutan' => 'required|integer',
    ]);

    if ($validator->fails()) {
        return Redirect::back()->withErrors($validator)->withInput();
    }

    DB::table('menus')
        ->where('id_menus', $id)
        ->update([
            'nama_menu' => $request->nama_menu,
            'url_link' => $request->url_link,
            'class' => $request->class,
            // 'id_menu_kategori' => $request->id_menu_kategori,
            // 'id_modules' => $request->id_modules,
            // 'posisi' => $request->posisi,
            'id_parent' => $request->id_parent ?? 0,
            'urutan' => $request->urutan,
        ]);

    return redirect()->route('menu-management')->with('success', 'Menu berhasil diperbarui.');
  }

  public function reorderMenus(Request $request)
  {
    $menuData = $request->input('menu_data');

    if (!is_array($menuData)) {
      return response()->json(['status' => 'error', 'message' => 'Data menu tidak valid.'], 400);
    }

    DB::beginTransaction();
    try {
      $this->processMenuOrder($menuData, 0); // Panggil fungsi rekursif untuk memproses data

      DB::commit();
      return response()->json(['status' => 'success', 'message' => 'Urutan menu berhasil diperbarui.']);
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json(['status' => 'error', 'message' => 'Gagal menyimpan urutan menu: ' . $e->getMessage()], 500);
    }
  }

  private function processMenuOrder(array $menuItems, $parentId = 0, &$urutan = 0)
  {
    foreach ($menuItems as $item)
    {
      $urutan++; // Tambah urutan setiap kali memproses item
      $id_menu = $item['id'];
      $newParentId = $parentId;

      // Perbarui menu di database
      DB::table('menus')
          ->where('id_menus', $id_menu)
          ->update([
              'urutan' => $urutan,
              'id_parent' => $newParentId
          ]);

      if (isset($item['children']) && is_array($item['children'])) {
        $this->processMenuOrder($item['children'], $id_menu, $urutan);
      }
    }
  }


  // access for the assign menu

  public function updateAccess(Request $request)
  {
    // Validasi
    $validator = Validator::make($request->all(), [
        'id_role'   => 'required|integer',
        'id_module' => 'required|integer',
        'access'    => 'nullable|array', // boleh kosong
    ]);

    if ($validator->fails()) {
        return Redirect::back()->withErrors($validator)->withInput();
    }

    // Set default access ke array kosong jika null
    $access = $request->input('access', []); // <= FIX PENTING

    DB::table('module_roles')->updateOrInsert([
      'id_module' => $request->id_module,
      'id_role'   => $request->id_role,
    ],
    [
      'can_read'   => in_array('read',   $access) ? 1 : 0,
      'can_create' => in_array('create', $access) ? 1 : 0,
      'can_update' => in_array('update', $access) ? 1 : 0,
      'can_delete' => in_array('delete', $access) ? 1 : 0,
    ]
    );

    return redirect()->route('menu-management')->with('success', 'Akses berhasil diperbarui.');
  }

  public function storeAssign(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'id_role' => 'required|integer',
      'id_module' => 'required|integer',
      'id_menus' => 'required|array',
    ]);

    if ($validator->fails())
    {
      return Redirect::back()->withErrors($validator)->withInput();
    }

    foreach ($request->id_menus as $id_menu)
    {
      $exists = DB::table('menu_roles')
      ->where('id_roles', $request->id_role)
      ->where('id_menus', $id_menu)
      ->exists();

      if (!$exists)
      {
        DB::table('menu_roles')->insert([
          'id_roles' => $request->id_role,
          'id_menus' => $id_menu,
        ]);
      }
    }

    DB::table('module_roles')
    ->updateOrInsert(
      [
        'id_module' => $request->id_module,
        'id_role' => $request->id_role,
      ],
      [
        'can_read' => 1,
        'can_create' => 0,
        'can_update' => 0,
        'can_delete' => 0,
      ]
    );

    return redirect()->route('menu-management')->with('success', 'Role berhasil diassign.');
  }

  public function destroyAssign(Request $request)
  {
    $request->validate([
      'id_role' => 'required|integer',
      'id_module' => 'required|integer',
    ]);

    DB::table('module_roles')
        ->where('id_module', $request->id_module)
        ->where('id_role', $request->id_role)
        ->delete();

    DB::table('menu_roles')
        ->where('id_roles', $request->id_role)
        ->delete();

    return redirect()->route('menu-management')->with('success', 'Role access berhasil dihapus.');
  }
}
