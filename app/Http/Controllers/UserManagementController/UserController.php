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
    // dd($users);

    return view('user_management/user_list.index', compact('users', 'breadcrumbHtml'));
  }
}
