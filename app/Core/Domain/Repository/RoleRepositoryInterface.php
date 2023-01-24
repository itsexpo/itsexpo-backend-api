<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Role\Role;

interface RoleRepositoryInterface
{
    public function persist(Role $role): void;

    public function delete(string $id): void;

    public function find(String $id): ?Role;

    public function getWithPagination(int $page, int $per_page): array;
}
