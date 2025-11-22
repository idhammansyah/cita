<?php

namespace App\Http\Controllers\ModuleController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModuleAssign extends Controller
{
  public function index()
  {
    $roles = DB::table('roles')->where('is_deleted', 0)->get();
    $modules = DB::table('modules')->orderBy('judul_modules')->get();

    return view('module_assignment.index', compact('roles','modules'));
  }

  public function getModuleData($id_module, Request $req)
  {
    $role = $req->role;

    $module = DB::table('modules')->where('id_modules', $id_module)->first();

    $perm = DB::table('module_roles')
      ->where('id_module', $id_module)
      ->where('id_role', $role)
      ->first();

    return response()->json([
      'module' => $module,
      'permissions' => [
        'can_read'   => $perm->can_read ?? 0,
        'can_create' => $perm->can_create ?? 0,
        'can_update' => $perm->can_update ?? 0,
        'can_delete' => $perm->can_delete ?? 0,
      ]
    ]);
  }

  public function saveAssign(Request $r)
  {
    DB::table('module_roles')->updateOrInsert([
      'id_role' => $r->id_role,
      'id_module' => $r->id_module
    ],
    [
      'can_read'   => $r->has('read')   ? 1 : 0,
      'can_create' => $r->has('create') ? 1 : 0,
      'can_update' => $r->has('update') ? 1 : 0,
      'can_delete' => $r->has('delete') ? 1 : 0,
    ]);

    return response()->json(['success' => true]);
  }
}
