<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Kabupaten\Kabupaten;

interface KabupatenRepositoryInterface
{
    /**
     * @param string $id
     * @return Kabupaten[]
     */
    public function getByProvinsiId(int $provinsi_id): array;

    public function find(int $id): ?Kabupaten;
}
