<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Role\Role;
use App\Core\Domain\Models\Role\RoleId;
use App\Core\Domain\Models\User\UserId;

interface RoleRepositoryInterface
{
    public function persist(Role $role): void;

    public function find(RoleId $id): ?Role;

    public function findByUserId(UserId $user_id): ?Role;
}
