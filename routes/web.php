<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController\AuthController as AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\AuthController\RoleController as role;
use App\Http\Controllers\MenuController\Menu;
use App\Http\Controllers\MenuController\MenuAssignment as menu_assignment;
use App\Http\Controllers\ModuleController\Module as module;
use App\Http\Controllers\ReimbursementController\Reimbursement as reimburse;
use App\Http\Controllers\UserManagementController\UserController;
use App\Http\Controllers\ModuleController\ModuleAssign;

use Illuminate\Support\Facades\Mail;
use App\Mail\NewReimbursementNotification;
use App\Models\Reimbursement\ReimbursementEmployee;
use App\Http\Controllers\TemplateController\Template as template_layout;
use App\Http\Controllers\DigitalCardController\ListUndangan\ListUndanganController as list_undangan;

// Route::get('/', [AuthController::class, 'v_login']);
Route::get('/login', [AuthController::class, 'v_login'])->name('login');
Route::post('/attempt-login', [AuthController::class, 'attemptlogin'])->name('attemptlogin');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// template view
Route::get('/template/flipbook-template', [template_layout::class, 'flipbook'])->name('flipbook-template');

Route::get('/invitation/wedding-of-idham-and-riska', [template_layout::class, 'wedding'])->name('wedding');

Route::middleware(['auth', 'module.access', 'role:1,2'])->group(function ()
{
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

  // Roles Management
  Route::get('/user-roles', [role::class, 'index']);
  Route::post('/user-roles/store', [role::class, 'add_roles'])->name('roles.store');
  Route::put('/user-roles-update/{id}', [role::class, 'update'])->name('roles.update');
  Route::delete('/delete-roles/{id}', [role::class, 'destroy'])->name('roles.destroy');

  // Menu Management
  Route::get('/menu-management', [Menu::class, 'index'])->name('menu.index');
  Route::get('/menu/get-all', [Menu::class, 'getAll']); // load tree
  Route::post('/menu/reorder', [Menu::class, 'reorder'])->name('menu.reorder');

  Route::post('/menu', [Menu::class, 'store'])->name('menu.store');
  Route::get('/menu/{id}', [Menu::class, 'show']);
  Route::put('/menu/{id}', [Menu::class, 'update']);
  Route::post('/menu/{id}/delete', [Menu::class, 'softDelete']);

  // Menu assignment
  Route::get('/menu-assignment', [menu_assignment::class, 'index'])->name('menu-assignment');
  Route::get('/menu-assignment/menus-tree', [menu_assignment::class, 'menusTree'])->name('menu.assignment.menusTree');
  Route::get('/menu-assignment/menu/{id}/roles', [menu_assignment::class, 'getRolesForMenu'])->name('menu.assignment.menu.roles');
  Route::post('/menu-assignment/menu/{id}/toggle-role',[menu_assignment::class, 'toggleRole'])->name('menu.assignment.menu.toggle');

  // Master Module
  Route::get('/master-module', [module::class, 'index'])->name('master-module');
  Route::post('/add-modules', [module::class, 'store'])->name('modules.store');
  Route::get('/edit-module/{id}', [module::class, 'edit'])->name('modules.edit');
  Route::put('/update-module/{id}', [module::class, 'update'])->name('modules.update');
  Route::post('/delete-module/{id}', [module::class, 'destroy'])->name('modules.destroy');

  // Module Assign
  Route::get('/module-assign', [ModuleAssign::class, 'index']);
  Route::get('/module-assign/get/{id}', [ModuleAssign::class, 'getModuleData']);
  Route::post('/module-assign/save',[ModuleAssign::class, 'saveAssign'])->name('module.assign.save');

  // users
  Route::get('/users', [UserController::class, 'index'])->name('users');
  Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
  Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
  Route::post('/users/{id}', [UserController::class, 'destroy'])->name('users.disable');
  Route::post('/users', [UserController::class, 'store'])->name('users.store');

  // reimbursement
  Route::get('/reimburse-menu', [reimburse::class, 'index'])->name('reimbursement-menu');
  Route::post('/reimbursements', [reimburse::class, 'store'])->name('reimbursements.store');
  Route::get('/reimbursements/{id}', [reimburse::class, 'show'])->name('reimbursements.show');
  Route::post('/reimbursements/{id}/delete', [reimburse::class, 'destroy'])->name('reimbursements.delete');
  Route::get('/reimbursements/{id}/edit', [reimburse::class, 'edit'])->name('reimbursements.edit');
  Route::post('/reimbursements/{id}/update', [reimburse::class, 'update'])->name('reimbursements.update');

  // routes for edit layout wedding invitation idham & riska
  Route::get('/edit/invitation/wedding-of-idham-and-riska', [template_layout::class, 'wedding'])->name('wedding');

  // routes for List Undangan idham & riska
  Route::get('/list-undangan', [list_undangan::class, 'index'])->name('list_undangan');

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
