<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProvinsiController;
use App\Http\Controllers\DesaController;

Route::get('hello', function () {
    return response()->json();
});

Route::post('/create_user', [UserController::class, 'createUser']);
Route::post('/login_user', [UserController::class, 'loginUser']);
Route::post('/user_verification', [UserController::class, 'userVerification']);
Route::get('/provinsi', [ProvinsiController::class, 'provinsi']);
Route::get('/desa', [DesaController::class, 'desa']);

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
