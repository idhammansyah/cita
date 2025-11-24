<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController\PenggunaController;

Route::middleware(['auth', 'module.access', 'role:3'])->group(function () {

  Route::get('/dashboard', [PenggunaController::class, 'index'])->name('dashboard');

});
