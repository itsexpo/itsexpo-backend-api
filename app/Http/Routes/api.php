<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KTIController;
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
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\JurnalistikController;
use App\Http\Controllers\UrlShortenerController;
use App\Http\Controllers\RobotInActionController;
use App\Http\Controllers\JurnalistikAdminController;
use App\Http\Controllers\KTIAdminController;
use App\Http\Controllers\RoleHasPermissionController;
use App\Http\Controllers\RobotInActionAdminController;
use App\Http\Controllers\WahanaSeniAdminController;
use App\Http\Controllers\WahanaSeniController;
use App\Http\Controllers\Wahana2DAdminController;

Route::get('hello', function () {
    return response()->json();
});

// User
Route::post('/create_user', [UserController::class, 'createUser']);
Route::post('/login_user', [UserController::class, 'loginUser'])->middleware('request.limit: 5, 2'); //request limit 100/menit
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

        // Robot In Action
        Route::post('/pre_event/robotik', [RobotInActionController::class, 'register'])->middleware('permission:robotik.store');
        Route::get('/pre_event/robotik', [RobotInActionController::class, 'get'])->middleware('permission:robotik.index');
        Route::post('/pre_event/robotik/join', [RobotInActionController::class, 'joinTeam'])->middleware('permission:robotik_join.store');
        Route::delete('/pre_event/robotik/team', [RobotInActionController::class, 'deleteTeam'])->middleware('permission:robotik_team.delete');

        // Jurnalistik admin
        Route::get('/admin/jurnalistik', [JurnalistikAdminController::class, 'getTeam'])->middleware('permission:admin_jurnalistik.index');
        Route::get('/admin/jurnalistik/{team_id}', [JurnalistikAdminController::class, 'getDetail'])->middleware('permission:admin_jurnalistik.detail');
        Route::patch('/admin/jurnalistik', [JurnalistikAdminController::class, 'confirmTeam'])->middleware('permission:admin_jurnalistik_approval.store');

        // Robot in Action admin
        Route::get('/admin/robotik', [RobotInActionAdminController::class, 'getTeam'])->middleware('permission:admin_robotik.index');
        Route::get('/admin/robotik/{team_id}', [RobotInActionAdminController::class, 'getDetail'])->middleware('permission:admin_robotik.detail');
        Route::patch('/admin/robotik', [RobotInActionAdminController::class, 'confirmTeam'])->middleware('permission:admin_robotik_approval.store');

        // Karya Tulis Ilmiah
        Route::post('/pre_event/kti', [KTIController::class, 'createKTITeam'])->middleware('permission:kti.store');
        Route::get('/pre_event/kti', [KTIController::class, 'getKTITeam'])->middleware('permission:kti.index');

        // Karya Tulis Ilmiah Admin
        Route::get('/admin/kti', [KTIAdminController::class, 'getTeam'])->middleware('permission:admin_kti.index');
        Route::get('/admin/kti/{team_id}', [KTIAdminController::class, 'getDetail'])->middleware('permission:admin_kti.detail');
        Route::post('/admin/kti/{team_id}', [KTIAdminController::class, 'passTeam'])->middleware('permission:admin_kti.store');
        Route::patch('/admin/kti', [KTIAdminController::class, 'confirmTeam'])->middleware('permission:admin_kti_approval.store');

        // Wahana seni
        Route::post('/main-event/2d', [WahanaSeniController::class, 'register2D'])->middleware('permission:wahana_2d.store');
        Route::post('/main-event/3d', [WahanaSeniController::class, 'register3D'])->middleware('permission:wahana_3d.store');
        Route::post('/main-event/2d/upload-berkas', [WahanaSeniController::class, 'uploadBerkas2D'])->middleware('permission:wahana_2d_upload_berkas.store');
        Route::post('/main-event/3d/upload-berkas', [WahanaSeniController::class, 'uploadBerkas3D'])->middleware('permission:wahana_3d_upload_berkas.store');
        Route::get('/main-event/wahana_seni', [WahanaSeniController::class, 'getDetail'])->middleware('permission:wahana_seni.index');

        // Wahana Seni Admin
        Route::patch('/admin/2d', [WahanaSeniAdminController::class, 'confirm2DTeam'])->middleware('permission:admin_wahana_seni_approval.store');
        Route::patch('/admin/3d', [WahanaSeniAdminController::class, 'confirm3DTeam'])->middleware('permission:admin_wahana_seni_approval.store');
        Route::get('/admin/3d', [WahanaSeniAdminController::class, 'getTeam'])->middleware('permission:admin_3d.index');
        Route::get('/admin/3d/{team_id}', [WahanaSeniAdminController::class, 'getDetailTeam'])->middleware('permission:admin_3d.detail');
        Route::get('/admin/2d', [Wahana2DAdminController::class, 'getPeserta'])->middleware('permission:admin_2d.index');
        Route::get('/admin/2d/{peserta_id}', [Wahana2DAdminController::class, 'getDetail'])->middleware('permission:admin_2d.detail');


        // Pembayaran
        Route::post('/pre_event/pembayaran/jurnalistik', [PembayaranController::class, 'createPembayaranJurnalistik'])->middleware('permission:pembayaran_jurnalistik.store');
        Route::get('/pre_event/pembayaran/jurnalistik', [PembayaranController::class, 'cekPembayaranJurnalistik'])->middleware('permission:pembayaran_jurnalistik.index');
        Route::post('/pre_event/pembayaran/kti', [PembayaranController::class, 'createPembayaranKTI'])->middleware('permission:pembayaran_kti.store');
        Route::get('/pre_event/pembayaran/kti', [KTIController::class, 'cekPembayaranKTI'])->middleware('permission:pembayaran_kti.index');
        Route::post('/pre_event/pembayaran/robotik', [PembayaranController::class, 'createPembayaran'])->middleware('permission:pembayaran_robotik.store');
        Route::get('/pre_event/pembayaran/robotik', [PembayaranController::class, 'cekPembayaran'])->middleware('permission:pembayaran_robotik.index');
        Route::put('/pre_event/pembayaran', [PembayaranController::class, 'updatePembayaran'])->middleware('permission:pembayaran.update');

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

        //Pengumuman
        Route::post('/pengumuman', [PengumumanController::class, 'add'])->middleware('permission:pengumuman.store');
        Route::get('/pengumuman', [PengumumanController::class, 'get']);
        Route::put('/pengumuman/{id}', [PengumumanController::class, 'update'])->middleware('permission:pengumuman.update');
        Route::delete('/pengumuman/{id}', [PengumumanController::class, 'delete'])->middleware('permission:pengumuman.delete');
    }
);
