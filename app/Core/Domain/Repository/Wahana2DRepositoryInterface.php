<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\NRP;
use App\Core\Domain\Models\Pembayaran\PembayaranId;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Models\Wahana2D\Wahana2D;
use App\Core\Domain\Models\Wahana2D\Wahana2DId;

interface Wahana2DRepositoryInterface
{
    public function find(Wahana2DId $id): ?Wahana2D;

    public function findByName(string $name): ?Wahana2D;

    public function findByUserId(UserId $user_id): ?Wahana2D;

    public function findByNrp(NRP $nrp): bool;

    public function findByPembayaranId(PembayaranId $pembayaran_id): ?Wahana2D;

    public function persist(Wahana2D $registrant): void;
}
