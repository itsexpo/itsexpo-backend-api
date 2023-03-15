<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\TestingController;
use App\Http\Controllers\FakultasController;
use App\Http\Controllers\ProvinsiController;
use App\Http\Controllers\KabupatenController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\JurnalistikController;
use App\Http\Controllers\UrlShortenerController;
use App\Http\Controllers\JurnalistikAdminController;
use App\Http\Controllers\KTIController;
use App\Http\Controllers\RoleHasPermissionController;
use App\Http\Controllers\RobotInActionController;

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

// Kecamatan
Route::get('/kecamatan', [KecamatanController::class, 'kecamatan']);

// Kabupaten
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

//Url Shortener
Route::get('/url_shortener', [UrlShortenerController::class, 'get']);

//Testing
Route::post('/store_image_test', [TestingController::class, 'storeImage']);

//Stream Image
Route::get('/stream_image', [ImageController::class, 'streamImage']);

Route::middleware(['iam'])->group(
    function () {
        Route::get('test', function () {
            return response()->json([
                "success" => true,
                "message" => "User Berhasil Mengakses Endpoint Ini"
            ]);
        })->middleware('permission:test.index');

        //Jurnalistik
        Route::get('/pre_event/jurnalistik', [JurnalistikController::class, 'get'])->middleware('permission:jurnalistik.index');
        Route::post('/pre_event/jurnalistik/join', [JurnalistikController::class, 'joinTeam'])->middleware('permission:jurnalistik_join.store');
        Route::delete('/pre_event/jurnalistik/team', [JurnalistikController::class, 'deleteTeam'])->middleware('permission:jurnalistik_team.delete');
        Route::post('/pre_event/jurnalistik/ketua', [JurnalistikController::class, 'createJurnalistikKetua'])->middleware('permission:jurnalistik_ketua.store');
        Route::post('/pre_event/jurnalistik/member', [JurnalistikController::class, 'createJurnalistikMember'])->middleware('permission:jurnalistik_member.store');
        Route::get('/pre_event/pembayaran/jurnalistik', [JurnalistikController::class, 'cekPembayaranJurnalistik'])->middleware('permission:pembayaran_jurnalistik.index');

        // Robot In Action
        Route::post('/pre_event/robotik', [RobotInActionController::class, 'register'])->middleware('permission:robot_in_action.store');
        Route::get('/pre_event/robotik', [RobotInActionController::class, 'get'])->middleware('permission:robot_in_action.index');

        // jurnalistik admin
        Route::get('/admin/jurnalistik', [JurnalistikAdminController::class, 'getTeam'])->middleware('permission:admin_jurnalistik.index');
        Route::get('/admin/jurnalistik/{team_id}', [JurnalistikAdminController::class, 'getDetail'])->middleware('permission:admin_jurnalistik.detail');
        Route::patch('/admin/jurnalistik', [JurnalistikAdminController::class, 'confirmTeam'])->middleware('permission:admin_jurnalistik_approval.store');

        // Karya Tulis Ilmiah
        Route::post('/pre_event/kti', [KTIController::class, 'createKTITeam'])->middleware('permission:kti.store');

        // Pembayaran
        Route::post('/pre_event/pembayaran/jurnalistik', [PembayaranController::class, 'createPembayaranJurnalistik'])->middleware('permission:pembayaran_jurnalistik.store');

        //User
        Route::get('/me', [UserController::class, 'me']);
        Route::post('/change_password', [UserController::class, 'changePassword']);

        //Url Shortener
        Route::post('/url_shortener', [UrlShortenerController::class, 'add'])->middleware('permission:url_shortener.store');
        Route::delete('/url_shortener', [UrlShortenerController::class, 'delete'])->middleware('permission:url_shortener.delete');
        Route::put('/url_shortener', [UrlShortenerController::class, 'update'])->middleware('permission:url_shortener.update');
        Route::get('/all_url_shortener', [UrlShortenerController::class, 'index'])->middleware('permission:all_url_shortener.index');

        //User
        Route::get('/users', [UserController::class, 'getUserList'])->middleware('permission:users.index');
        Route::delete('/users', [UserController::class, 'deleteUser'])->middleware('permission:users.delete');

        //Role
        Route::get('/roles', [RoleController::class, 'getRoleList'])->middleware('permission:roles.index');
        Route::post('/roles', [RoleController::class, 'add'])->middleware('permission:roles.store');
        Route::delete('/roles', [RoleController::class, 'delete'])->middleware('permission:roles.delete');
        Route::put('/roles', [RoleController::class, 'update'])->middleware('permission:roles.update');
        Route::get('/roles/{id_role}', [RoleHasPermissionController::class, 'getRolePermission'])->middleware('permission:roles.detail');
        Route::post('/roles_assign', [RoleHasPermissionController::class, 'add'])->middleware('permission:roles_assign.store');
        Route::delete('/roles_unassign', [RoleHasPermissionController::class, 'delete'])->middleware('permission:roles_unassign.store');

        //Permission
        Route::get('/permissions', [PermissionController::class, 'getPermissionList'])->middleware('permission:permissions.index');
        Route::post('/permissions', [PermissionController::class, 'add'])->middleware('permission:permissions.store');
        Route::delete('/permissions', [PermissionController::class, 'delete'])->middleware('permission:permissions.delete');
        Route::put('/permissions', [PermissionController::class, 'update'])->middleware('permission:permissions.update');
    }
);
