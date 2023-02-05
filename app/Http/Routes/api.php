<?php

use App\Core\Domain\Models\Permission\Permission;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FakultasController;
use App\Http\Controllers\ProvinsiController;
use App\Http\Controllers\KabupatenController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleHasPermissionController;

Route::get('hello', function () {
    return response()->json();
});

// User
Route::post('/create_user', [UserController::class, 'createUser']);
Route::post('/login_user', [UserController::class, 'loginUser']);
Route::post('/user_verification', [UserController::class, 'userVerification']);
Route::get('/user_verification', [UserController::class, 'reUserVerification']);

// Provinsi
Route::get('/provinsi', [ProvinsiController::class, 'provinsi']);

#GET Kecamatan
Route::get('/kecamatan', [KecamatanController::class, 'kecamatan']);

#GET Kabupaten
Route::get('/kabupaten', [KabupatenController::class, 'kabupaten']);

// Desa
Route::get('/desa', [DesaController::class, 'desa']);

// Fakultas dan Departemen
Route::get('/fakultas', [FakultasController::class, 'fakultas']);
Route::get('/departemen', [DepartemenController::class, 'departemen']);

// Forgot Password
Route::group(['prefix' => '/forgot_password'], function () {
    Route::post('/request', [UserController::class, 'requestForgotPassword']);
    Route::post('/change', [UserController::class, 'changeForgotPassword']);
});

Route::middleware(['iam'])->group(
    function () {
        Route::get('test', function () {
            return response()->json([
                "success" => true,
                "message" => "User Berhasil Mengakses Endpoint Ini"
            ]);
        })->middleware('permission:test.index');

        Route::get('/me', [UserController::class, 'me']);
        Route::post('/change_password', [UserController::class, 'changePassword']);

        //User
        Route::get('/users', [UserController::class, 'getUserList'])->middleware('permission:users.index');
        Route::post('/users/delete', [UserController::class, 'deleteUser'])->middleware('permission:users.delete');

        //Role
        Route::get('/roles', [RoleController::class, 'getRoleList'])->middleware('permission:roles.index');
        Route::post('/roles', [RoleController::class, 'add'])->middleware('permission:roles.store');
        Route::post('/roles/delete', [RoleController::class, 'delete'])->middleware('permission:roles.delete');
        Route::post('/roles/update', [RoleController::class, 'update'])->middleware('permission:roles.update');
        Route::post('/roles_assign', [RoleHasPermissionController::class, 'add'])->middleware('permission:roles_assign.store');
        Route::post('/roles_unassign', [RoleHasPermissionController::class, 'delete'])->middleware('permission:roles_unassign.store');

        //Permission
        Route::get('/permissions', [PermissionController::class, 'getPermissionList'])->middleware('permission:permissions.index');
        Route::post('/permissions', [PermissionController::class, 'add'])->middleware('permission:permissions.store');
        Route::post('/permissions/delete', [PermissionController::class, 'delete'])->middleware('permission:permissions.delete');
        Route::post('/permissions/update', [PermissionController::class, 'update'])->middleware('permission:permissions.update');
    }
);

Route::middleware(['iam', 'admin'])->group(
    function () {
    }
);
