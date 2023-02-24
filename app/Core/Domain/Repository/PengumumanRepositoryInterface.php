<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Pengumuman\Pengumuman;
use App\Core\Domain\Models\Pengumuman\PengumumanId;

interface PengumumanRepositoryInterface
{
    public function persist(Pengumuman $pengumuman): void;

    public function update(PengumumanId $id, int $event_id, string $title, string $description): void;

    public function delete(PengumumanId $id): void;

    public function getAll(): array;

    public function getByEventId(int $event_id): array;

    public function getById(string $id);
}
