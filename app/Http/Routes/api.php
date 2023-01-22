<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FakultasController;
use App\Http\Controllers\ProvinsiController;
use App\Http\Controllers\KabupatenController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\DepartemenController;

Route::get('hello', function () {
    return response()->json();
});

// User
Route::post('/create_user', [UserController::class, 'createUser']);
Route::post('/login_user', [UserController::class, 'loginUser']);
Route::post('/user_verification', [UserController::class, 'userVerification']);
Route::get('/users', [UserController::class, 'getUserList']);
Route::post('/users/delete', [UserController::class, 'deleteUser']);

//Role
Route::get('/roles', [RoleController::class, 'getRoleList']);
Route::post('/roles', [RoleController::class, 'add']);
Route::post('/roles/delete', [RoleController::class, 'delete']);
Route::post('/roles/update', [RoleController::class, 'update']);
Route::post('/api/roles_assign', [RoleController::class, 'assignRolePermission']);
Route::post('/api/roles_assign/delete', [RoleController::class, 'deleteRolePermission']);

//Permission
Route::get('/permission', [PermissionController::class, 'getPermissionList']);
Route::post('/permission', [PermissionController::class, 'add']);
Route::post('/permission/delete', [PermissionController::class, 'delete']);
Route::post('/permission/update', [PermissionController::class, 'update']);



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

Route::middleware(['iam'])->group(
    function () {
        Route::get('test', function () {
            return response()->json([
                "success" => true
            ]);
        });
        Route::get('/me', [UserController::class, 'me']);
    }
);

Route::middleware(['iam', 'admin'])->group(
    function () {
    }
);
