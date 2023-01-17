<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProvinsiController;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\FakultasController;

Route::get('hello', function () {
    return response()->json();
});

// User
Route::post('/create_user', [UserController::class, 'createUser']);
Route::post('/login_user', [UserController::class, 'loginUser']);
Route::post('/user_verification', [UserController::class, 'userVerification']);

// Provinsi
Route::get('/provinsi', [ProvinsiController::class, 'provinsi']);

#GET Kecamatan
Route::get('/kecamatan', [KecamatanController::class, 'kecamatan']);

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
