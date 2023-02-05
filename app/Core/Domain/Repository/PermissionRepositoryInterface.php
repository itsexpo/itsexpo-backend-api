<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Permission\Permission;

interface PermissionRepositoryInterface
{
    public function persist(Permission $permission): void;

    public function delete(string $id): void;

    public function find(String $id): ?Permission;

    public function findLargestId(): ?string;

    public function getWithPagination(int $page, int $per_page): array;

    public function getAll(): array;
}
