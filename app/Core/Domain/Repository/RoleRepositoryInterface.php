<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Role\Role;

interface RoleRepositoryInterface
{
    public function persist(Role $role): void;

    public function find(string $id): ?Role;
}
