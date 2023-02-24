<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\StatusPembayaran\StatusPembayaran;

interface StatusPembayaranRepositoryInterface
{
    public function find(int $id): ?StatusPembayaran;
}
