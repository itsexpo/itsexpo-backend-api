<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Desa\Desa;

interface DesaRepositoryInterface
{
    /**
     * @param string $id
     * @return Desa[]
     */
    public function getAll(): array;

    public function getByKecamatanId(int $kecamatan_id): array;

    public function find(int $id): ?Desa;
}
