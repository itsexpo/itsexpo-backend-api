<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Fakultas\Fakultas;

interface FakultasRepositoryInterface
{
    /**
     * @return Fakultas[]
     */
    public function getAll(): array;
}
