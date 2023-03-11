<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Pembayaran\Pembayaran;
use App\Core\Domain\Models\Pembayaran\PembayaranId;

interface PembayaranRepositoryInterface
{
    public function find(PembayaranId $id): ?Pembayaran;

    // public function getById(string $id): ?Pembayaran;

    public function changeStatusPembayaran(PembayaranId $id, int $status_pembayaran_id): void;
}
