<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\RoleHasPermission\RoleHasPermission;

interface RoleHasPermissionRepositoryInterface
{
    public function persist(RoleHasPermission $RoleHasPermission): void;

    public function delete(string $id): void;

    public function find(string $id): ?RoleHasPermission;

    public function findByRoleId(string $role_id): ?array;

    public function findByPermissionId(string $permission_id): ?array;

    public function findLargestId(): ?string;

    public function findByBoth(string $role_id, string $permission_id): ?RoleHasPermission;

    public function getPermissionByRole(string $role_id): ?array;
}
