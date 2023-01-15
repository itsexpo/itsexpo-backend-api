<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Permission\Permission;

interface PermissionRepositoryInterface
{
    public function persist(Permission $permission): void;

    public function find(string $id): ?Permission;
}
