<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Kecamatan\Kecamatan;

interface KecamatanRepositoryInterface
{
    /**
     * @return Kecamatan[]
     */
    public function getAll(): array;

    /**
     * @param string $id
     * @return Kecamatan[]
     */
    public function getByKabupatenId(int $kabupaten_id): array;

    public function find(int $id): ?Kecamatan;
}
