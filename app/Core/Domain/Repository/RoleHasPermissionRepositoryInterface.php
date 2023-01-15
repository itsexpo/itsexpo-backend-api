<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\RoleHasPermission\RoleHasPermission;

interface RoleHasPermissionRepositoryInterface
{
    public function persist(RoleHasPermission $RoleHasPermission): void;

    public function find(string $id): ?RoleHasPermission;

    public function findByRoleId(string $role_id): ?RoleHasPermission;

    public function findByPermissionId(string $permission_id): ?RoleHasPermission;
}
