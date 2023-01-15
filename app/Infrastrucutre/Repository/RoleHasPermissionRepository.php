<?php

namespace App\Infrastrucutre\Repository;

use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\Role\RoleId;
use App\Core\Domain\Models\Permission\PermissionId;
use App\Core\Domain\Models\RoleHasPermission\RoleHasPermission;
use App\Core\Domain\Models\RoleHasPermission\RoleHasPermissionId;
use App\Core\Domain\Repository\RoleHasPermissionRepositoryInterface;

class SqlRoleHasPermissionRepository implements RoleHasPermissionRepositoryInterface
{
    public function persist(RoleHasPermission $role_has_permission): void
    {
        DB::table('role_has_permission')->upsert([
            'id' => $role_has_permission->getId()->toString(),
            'role_id' => $role_has_permission->getRoleId()->toString(),
            'permission_id' => $role_has_permission->getPermissionId()->toString(),
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(RoleHasPermissionId $id): ?RoleHasPermission
    {
        $row = DB::table('role_has_permission')->where('id', $id->toString())->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRow($row);
    }

    /**
     * @throws Exception
     */
    public function findByRoleId(RoleId $role_id): ?RoleHasPermission
    {
        $row = DB::table('role_has_permission')->where('role_id', $role_id->toString())->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRow($row);
    }

    /**
     * @throws Exception
     */
    public function findByPermissionId(PermissionId $permission_id): ?RoleHasPermission
    {
        $row = DB::table('role_has_permission')->where('permission_id', $permission_id->toString())->first();

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
            new RoleHasPermissionId($row->id),
            new RoleId($row->role_id),
            new PermissionId($row->permission_id),
        );
    }
}
