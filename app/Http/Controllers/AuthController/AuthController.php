<?php

namespace App\Http\Controllers\AuthController;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

  public function v_login()
  {
    $data = [
      'title' => 'Login Page'
    ];

    return view('auth.login', compact('data'));
  }

  public function attemptlogin(Request $request)
  {
    $request->validate([
      'username' => 'required',
      'password' => 'required',
    ]);

    if (Auth::attempt($request->only('username', 'password')))
    {
      $user = Auth::user();

      // Update kolom is_login
      $user->is_login = 1;
      $user->save();

      // if ($user->role_id == 3) {
      //   // Redirect ke halaman khusus pengguna biasa
      //   return redirect()->route('user.dashboard')->with('success', 'Selamat datang!');
      // }

      return redirect()->route('dashboard')->with('success', 'Login berhasil');
    } else {
      return back()->withErrors(['username' => 'Username atau password salah']);
    }
  }

  public function logout()
  {
    $user = Auth::user();
    $user->is_login = 0;
    $user->save();

    Auth::logout();

    return redirect()->to('/login')->with('success', 'Logout berhasil');
  }

}
