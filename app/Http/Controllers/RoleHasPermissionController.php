<?php

namespace App\Http\Controllers;

use Exception;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Core\Application\Service\AddRoleHasPermission\AddRoleHasPermissionRequest;
use App\Core\Application\Service\AddRoleHasPermission\AddRoleHasPermissionService;
use App\Core\Application\Service\DeleteRoleHasPermission\DeleteRoleHasPermissionRequest;
use App\Core\Application\Service\DeleteRoleHasPermission\DeleteRoleHasPermissionService;

class RoleHasPermissionController extends Controller
{
    public function add(Request $request, AddRoleHasPermissionService $service): JsonResponse
    {
        $input = new AddRoleHasPermissionRequest(
            $request->input('role_id'),
            $request->input('permission_id')
        );

        DB::beginTransaction();
        try {
            $service->execute($input);
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->success("RoleHasPermission Berhasil ditambahkan");
    }

    public function delete(Request $request, DeleteRoleHasPermissionService $service): JsonResponse
    {
        $input = new DeleteRoleHasPermissionRequest(
            $request->input('role_has_permission_id')
        );

        DB::beginTransaction();
        try {
            $service->execute($input);
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->success("RoleHasPermission Berhasil diHapus");
    }
}