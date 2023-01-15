<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('hello', function () {
    return response()->json();
});

Route::post('/create_user', [UserController::class, 'createUser']);
Route::post('/login_user', [UserController::class, 'loginUser']);
Route::post('/user_verification', [UserController::class, 'userVerification']);

Route::middleware(['iam'])->group(
    function () {
        Route::get('test', function () {
            return response()->json([
                "success" => true
            ]);
        });
        Route::post('/me', [UserController::class, 'me']);
    }
);

Route::middleware(['iam', 'admin'])->group(
    function () {
    }
);
