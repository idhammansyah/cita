<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
  public function index()
  {
    $totalUsers = User::count();
    $activeUsers = User::whereNotNull('is_login')->count();
    return view('dashboard.index', compact('totalUsers', 'activeUsers'));
  }
}
