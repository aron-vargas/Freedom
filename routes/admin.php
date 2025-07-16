<?php

use App\Http\Controllers\Admin\UserAdministrationController;
use App\Http\Controllers\Admin\RoleAdministrationController;
use App\Http\Controllers\Admin\PermissionAdministrationController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::redirect('admin', 'admin/user/list');
    Route::redirect('admin/user', 'admin/user/list');
    Route::redirect('admin/role', 'admin/role/list');
    Route::redirect('admin/permission', 'admin/permission/list');

    Route::get('admin/user/list', [UserAdministrationController::class, 'list'])->name('user.list');
    Route::get('admin/user/edit', [UserAdministrationController::class, 'edit'])->name('user.edit');
    Route::patch('admin/user/update', [UserAdministrationController::class, 'update'])->name('user.update');
    Route::delete('admin/user/delete', [UserAdministrationController::class, 'destroy'])->name('user.destroy');

    Route::get('admin/role/list', [RoleAdministrationController::class, 'list'])->name('role.list');
    Route::get('admin/role/edit', [RoleAdministrationController::class, 'edit'])->name('role.edit');
    Route::patch('admin/role/update', [RoleAdministrationController::class, 'update'])->name('role.update');
    Route::delete('admin/role/delete', [RoleAdministrationController::class, 'destroy'])->name('role.destroy');

    Route::get('admin/permission/list', [PermissionAdministrationController::class, 'list'])->name('permission.list');
    Route::get('admin/permission/edit', [PermissionAdministrationController::class, 'edit'])->name('permission.edit');
    Route::patch('admin/permission/update', [PermissionAdministrationController::class, 'update'])->name('permission.update');
    Route::delete('admin/permission/delete', [PermissionAdministrationController::class, 'destroy'])->name('permission.destroy');
});