<?php

namespace App\Http\Controllers\MenuController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class MenuAssignment extends Controller
{
  public function index()
  {
    $roles = DB::table('roles')->where('is_deleted', 0)->orderBy('nama_roles')->get();

    $kategori = DB::table('menus_kategori')->where('is_active', 1)->orderBy('urutan')->get();

    return view('menu_assignment.index', compact('roles', 'kategori'));
  }

  public function menusTree()
  {
    $menus = DB::table('menus')
      ->where('is_active', 1)
      ->orderBy('id_menu_kategori')
      ->orderBy('id_parent')
      ->orderBy('urutan')
      ->get();

    // build tree structure with depth info
    $tree = $this->buildTree($menus);

    return response()->json(['tree' => $tree]);
  }

  private function buildTree($menus, $parent = 0, $depth = 0)
  {
    $branch = [];
    foreach ($menus as $m) {
      if ((int)$m->id_parent === (int)$parent) {
        $children = $this->buildTree($menus, $m->id_menus, $depth + 1);
        $branch[] = [
          'id' => $m->id_menus,
          'name' => $m->nama_menu,
          'url' => $m->url_link,
          'class' => $m->class,
          'id_parent' => $m->id_parent,
          'depth' => $depth,
          'children' => $children,
        ];
      }
    }
    return $branch;
  }

  public function getRolesForMenu($id, Request $request)
  {
    $roles = DB::table('roles')->where('is_deleted', 0)->orderBy('nama_roles')->get();

    $assigned = DB::table('menu_roles')->where('id_menus', $id)->pluck('id_roles')->toArray();

    return response()->json([
      'menu_id' => (int)$id,
      'roles' => $roles,
      'assigned' => $assigned,
    ]);
  }

  public function toggleRole($id, Request $request)
  {
    $roleId = (int)$request->input('role_id');
    $assign = (int)$request->input('assign'); // 1 insert, 0 delete

    if (!$roleId) {
      return response()->json(['success' => false, 'message' => 'role_id required'], 400);
    }

    if ($assign === 1) {
      DB::table('menu_roles')->insertOrIgnore([
        'id_roles' => $roleId,
        'id_menus' => $id,
      ]);

      return response()->json(['success' => true, 'message' => 'Assigned']);
    } else {
      DB::table('menu_roles')
        ->where('id_roles', $roleId)
        ->where('id_menus', $id)
        ->delete();
        return response()->json(['success' => true, 'message' => 'Unassigned']);
    }
  }
}
