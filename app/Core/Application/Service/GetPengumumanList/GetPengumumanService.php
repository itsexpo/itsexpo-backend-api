<?php

namespace App\Core\Application\Service\GetpengumumanList;

use App\Core\Domain\Repository\PengumumanRepositoryInterface;
use App\Exceptions\UserException;

class GetPengumumanService
{
    private PengumumanRepositoryInterface $pengumuman_repository;

    public function __construct(PengumumanRepositoryInterface $pengumuman_repository)
    {
        $this->pengumuman_repository = $pengumuman_repository;
    }

    public function execute(GetPengumumanRequest $request)
    {
        $event_id = $request->getEventId();
        $id = $request->getPengumumanId();

        if ($event_id) {
            $PengumumanByEventId = $this->pengumuman_repository->getByEventId($event_id);
            return $PengumumanByEventId;
        }
        if ($id) {
            $pengumuman = $this->pengumuman_repository->getById($id);
            if (!$pengumuman) {
                UserException::throw("Pengumuman tidak ditemukan", 1231, 404);
            }
            return $pengumuman;
        } else {
            $allPengumuman = $this->pengumuman_repository->getAll();
            return $allPengumuman;
        }
    }
}
