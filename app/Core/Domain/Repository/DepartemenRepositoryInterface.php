<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Departemen\Departemen;

interface DepartemenRepositoryInterface
{
    /**
     * @param string $id
     * @return Departemen[]
     */
    public function getByFakultasId(int $fakultas_id): array;

    public function find(int $id): ?Departemen;

    public function getAll() : array;
}
