<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Permission\Permission;
use App\Core\Domain\Models\Permission\PermissionId;

interface PermissionRepositoryInterface
{
    public function persist(Permission $permission): void;

    public function find(PermissionId $id): ?Permission;
}
