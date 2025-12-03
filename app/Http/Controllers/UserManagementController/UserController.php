<?php

namespace App\Http\Controllers\UserManagementController;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
  public function index()
  {
    $users = $this->user->getUserRole();
    $breadcrumbHtml = renderBreadcrumb();
    $roles = DB::table('roles')->where('is_deleted', 0)->get();

    return view('user_management/user_list.index', compact('users', 'breadcrumbHtml', 'roles'));
  }

  public function edit($id)
  {
    $user = DB::table('users')->where('id', $id)->first();

    if (!$user) {
      return response()->json(['message' => 'User not found'], 404);
    }

    return response()->json($user);
  }

  public function destroy($id)
  {
    DB::table('users')
      ->where('id', $id)
      ->update([
        'is_active' => 0,
        'updated_at' => now(),
      ]);

    return response()->json(['message' => 'User deleted']);
  }
}
