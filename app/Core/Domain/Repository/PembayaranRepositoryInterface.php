<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Pembayaran\Pembayaran;
use App\Core\Domain\Models\Pembayaran\PembayaranId;

interface PembayaranRepositoryInterface
{
    public function find(PembayaranId $id): ?Pembayaran;
}
