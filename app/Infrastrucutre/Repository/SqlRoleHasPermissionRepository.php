<?php

namespace App\Infrastrucutre\Repository;

use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\RoleHasPermission\RoleHasPermission;
use App\Core\Domain\Repository\RoleHasPermissionRepositoryInterface;

class SqlRoleHasPermissionRepository implements RoleHasPermissionRepositoryInterface
{
    public function persist(RoleHasPermission $role_has_permission): void
    {
        DB::table('role_has_permission')->upsert([
            'id' => $role_has_permission->getId(),
            'role_id' => $role_has_permission->getRoleId(),
            'permission_id' => $role_has_permission->getPermissionId(),
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(string $id): ?RoleHasPermission
    {
        $row = DB::table('role_has_permission')->where('id', $id)->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRow($row);
    }

    /**
     * @throws Exception
     */
    public function findByRoleId(string $role_id): ?RoleHasPermission
    {
        $row = DB::table('role_has_permission')->where('role_id', $role_id)->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRow($row);
    }

    /**
     * @throws Exception
     */
    public function findByPermissionId(string $permission_id): ?RoleHasPermission
    {
        $row = DB::table('role_has_permission')->where('permission_id', $permission_id)->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRow($row);
    }

    /**
     * @throws Exception
     */
    private function constructFromRow($row): RoleHasPermission
    {
        return new RoleHasPermission(
            $row->id,
            $row->role_id,
            $row->permission_id,
        );
    }
}
