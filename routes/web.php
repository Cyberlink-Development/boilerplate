<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Permissions\PermissionController;
use App\Http\Controllers\Admin\Roles\RoleController;
use App\Http\Controllers\Admin\RolesAndPermissions\RoleAndPermissionController;
use App\Http\Controllers\Admin\SiteSettings\SiteSettingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Frontend\HomeController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

route::get('/register', [RegisterController:: class,'create'])->name('register.create')->middleware('guest');
route::post('/register/update', [RegisterController:: class,'store'])->name('register.store')->middleware('guest');

route::get('/login', [LoginController::class, 'login'])->name('login')->middleware('guest');
route::post('/authenticate', [LoginController::class,'authenticate'])->name('authenticate')->middleware('guest');

route::get('/admins', [LoginController::class, 'admin_login'])->name('admin.login')->middleware('guest');
route::post('/admin/authenticate', [LoginController::class,'admin_authenticate'])->name('admin.authenticate')->middleware('guest');
// route::get('/admin/register', [RegisterController:: class,'create'])->name('admin.register');
// route::post('/admin/register', [RegisterController:: class,'create'])->name('admin.register');

route::get('/logout', [LoginController::class,'logout'])->name('logout');
route::get('/userfront', [DashboardController::class,'userfront'])->name('userfront');

/*************************************************************************************************************/
/***************************************** Frontend Routes ***************************************************/
/*************************************************************************************************************/

route::get('/', [HomeController::class,'index'])->name('home');

/*************************************************************************************************************/
/****************************************** Backend Routes ***************************************************/
/*************************************************************************************************************/

Route::group(['prefix' => 'admin', 'middleware'=> ['admin']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('roles', RoleController::class);
    route::resource('permissions', PermissionController::class);
    route::resource('manage-admins', AdminController::class);
    route::get('rolesandpermisisons', [RoleAndPermissionController::class,'index'])->name('rolesandpermissions.index');
    route::get('rolesandpermisisons/permissionUpdate/{id}', [RoleAndPermissionController::class,'permission_update'])->name('permissionUpdate');
    Route::get('site-settings', [SiteSettingController::class, 'index'])->name('site-settings.index');
    Route::post('site-settings', [SiteSettingController::class, 'storeOrUpdate'])->name('site-settings.store');
    route::get('delete-admin-image/{id}', [AdminController::class,'delete_image'])->name('delete-admin-image');
    route::get('delete-logo/{id}', [SiteSettingController::class, 'delete_logo'])->name('delete-logo');
    // other routes that require 'super' role...
});
