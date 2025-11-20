<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController\AuthController as AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\AuthController\RoleController as role;
use App\Http\Controllers\MenuController\Menu;
use App\Http\Controllers\ModuleController\Module as module;
use App\Http\Controllers\ReimbursementController\Reimbursement as reimburse;
use App\Http\Controllers\UserManagementController\UserController;

use Illuminate\Support\Facades\Mail;
use App\Mail\NewReimbursementNotification;
use App\Models\Reimbursement\ReimbursementEmployee;

// Route::get('/', [AuthController::class, 'v_login']);
Route::get('/login', [AuthController::class, 'v_login'])->name('login');
Route::post('/attempt-login', [AuthController::class, 'attemptlogin'])->name('attemptlogin');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Route::middleware('auth')->group(function ()
Route::middleware(['auth', 'module.access'])->group(function ()
{
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

  // Roles Management
  Route::get('/user-roles', [role::class, 'index']);
  Route::post('/user-roles/store', [role::class, 'add_roles'])->name('roles.store');
  Route::put('/user-roles-update/{id}', [role::class, 'update'])->name('roles.update');
  Route::delete('/delete-roles/{id}', [role::class, 'destroy'])->name('roles.destroy');

  // Menu Managaement
  // assign
  Route::get('/menu-management', [Menu::class, 'index'])->name('menu-management');
  Route::post('/menu-management/update-access', [Menu::class, 'updateAccess'])->name('menu.management.update');
  Route::post('/menu-management/assign', [Menu::class, 'storeAssign'])->name('menu.management.assign.store');
  Route::delete('/menu-management/assign', [Menu::class, 'destroyAssign'])->name('menu.management.assign.destroy');
  // menu
  Route::get('/menu/{id}', [Menu::class, 'show']);
  Route::put('/menu/{id}', [Menu::class, 'update']);
  Route::delete('/menu/{id}', [Menu::class, 'destroy']);
  Route::post('/menu/store', [Menu::class, 'store'])->name('menu.store'); //
  Route::get('/menus/by-category/{id}', [Menu::class, 'getByCategory'])->name('menu.byCategory');
  Route::post('/menu/reorder', [Menu::class, 'reorderMenus'])->name('menu.reorder');
  Route::get('/menu/get-by-category/{id}', [Menu::class, 'getByCategory'])->name('menu.get-by-category');
  Route::get('/menu/{id}', [Menu::class, 'get_menu_by_id'])->name('menu.show');
  Route::put('/menu/{id}', [Menu::class, 'update_menu'])->name('menu.update');

  // Master Module
  Route::get('/master-module', [module::class, 'index'])->name('master-module');
  Route::post('/add-modules', [module::class, 'store'])->name('modules.store');
  Route::get('/edit-module/{id}', [module::class, 'edit'])->name('modules.edit');
  Route::put('/update-module/{id}', [module::class, 'update'])->name('modules.update');
  Route::delete('/delete-module/{id}', [module::class, 'destroy'])->name('modules.destroy');

  Route::get('/users', [UserController::class, 'index'])->name('users');
  Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
  Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
  Route::patch('/users/{id}', [UserController::class, 'destroy'])->name('users.disable');
  Route::post('/users', [UserController::class, 'store'])->name('users.store');

  // reimbursement
  Route::get('/reimburse-menu', [reimburse::class, 'index'])->name('reimbursement-menu');
  Route::post('/reimbursements', [reimburse::class, 'store'])->name('reimbursements.store');
  Route::get('/reimbursements/{id}', [reimburse::class, 'show'])->name('reimbursements.show');
  Route::post('/reimbursements/{id}/delete', [reimburse::class, 'destroy'])->name('reimbursements.delete');
  Route::get('/reimbursements/{id}/edit', [reimburse::class, 'edit'])->name('reimbursements.edit');
  Route::post('/reimbursements/{id}/update', [reimburse::class, 'update'])->name('reimbursements.update');

  // approve untuk manager
  Route::post('/reimbursements/{id}/approve', [reimburse::class, 'approve'])->name('reimbursements.approve');
  Route::post('/reimbursements/{id}/reject', [reimburse::class, 'reject'])->name('reimbursements.reject');

  Route::get('/test-email-sync', function () {
    // Ambil data reimbursement yang sudah ada, atau buat dummy jika belum ada data
    $reimbursement = ReimbursementEmployee::with(['user', 'category'])->first();

    if (!$reimbursement) {
        return "Error: No reimbursement data found. Create one first or make a dummy here.";
    }

    // Ganti dengan email tujuan yang valid (misalnya, email Mailtrap Anda)
    $testEmailTo = 'tujuan_test@mailtrap.io';

    try {
      Mail::to($testEmailTo)->send(new NewReimbursementNotification($reimbursement));
      return "Email sent synchronously! Check your Mailtrap inbox.";
    } catch (\Exception $e) {
      // Ini akan menampilkan error jika pengiriman langsung gagal
      return "Email sending failed synchronously: " . $e->getMessage();
    }
  });
});
