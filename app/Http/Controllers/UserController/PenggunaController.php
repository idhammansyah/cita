<?php

namespace App\Http\Controllers\UserController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class PenggunaController extends Controller
{
  public function index()
  {
    $users = User::all();

    return view('user.dashboard.index', compact('users'));
  }
}
