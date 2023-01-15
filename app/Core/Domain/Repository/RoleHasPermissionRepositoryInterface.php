<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Role\RoleId;
use App\Core\Domain\Models\Permission\PermissionId;
use App\Core\Domain\Models\RoleHasPermission\RoleHasPermission;
use App\Core\Domain\Models\RoleHasPermission\RoleHasPermissionId;

interface RoleHasPermissionRepositoryInterface
{
    public function persist(RoleHasPermission $RoleHasPermission): void;

    public function find(RoleHasPermissionId $id): ?RoleHasPermission;

    public function findByRoleId(RoleId $role_id): ?RoleHasPermission;

    public function findByPermissionId(PermissionId $permission_id): ?RoleHasPermission;
}
