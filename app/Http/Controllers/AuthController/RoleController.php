<?php

namespace App\Http\Controllers\AuthController;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Authentication\Role;

class RoleController extends Controller
{
  public function index()
  {
    $users = User::all();
    $breadcrumbHtml = renderBreadcrumb();
    $roles = Role::where('is_deleted', 0)->get();

    return view('user_management/user_roles.index', compact('users', 'breadcrumbHtml', 'roles'));
  }

  public function add_roles(Request $request)
  {
    $request->validate([
      'role_name' => 'required|string|max:100|unique:roles,nama_roles',
    ]);

    Role::create([
      'nama_roles' => $request->role_name,
      'is_deleted' => 0
    ]);

    return redirect()->back()->with('success', 'Role berhasil ditambahkan.');
  }

  public function update(Request $request, $id_roles)
  {
    $request->validate([
      'role_name' => 'required|string|max:100|unique:roles,nama_roles',
    ]);

    Role::where('id_roles', $id_roles)->update([
      'nama_roles' => $request->role_name
    ]);

    return response()->json(['message' => 'Updated']);
  }

  public function destroy($id)
  {
    $role = Role::where('is_deleted', 0)->findOrFail($id);
    $role->is_deleted = 1;
    $role->save();

    return response()->json(['message' => 'Role berhasil dihapus (soft delete).']);
  }

}
