<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\ListEvent\ListEvent;

interface ListEventRepositoryInterface
{
    public function find(int $id): ?ListEvent;

    public function getAll(): array;
}
