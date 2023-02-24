<?php

namespace App\Core\Application\Service\UpdatePengumuman;

use App\Core\Domain\Models\Pengumuman\PengumumanId;
use App\Core\Domain\Repository\PengumumanRepositoryInterface;
use App\Exceptions\UserException;

class UpdatePengumumanService
{
    private PengumumanRepositoryInterface $pengumuman_repository;

    public function __construct(PengumumanRepositoryInterface $pengumuman_repository)
    {
        $this->pengumuman_repository = $pengumuman_repository;
    }

    public function execute(UpdatePengumumanRequest $request)
    {
        $pengumumanId = new PengumumanId($request->getPengumumanId());
        $exist = $this->pengumuman_repository->getById($pengumumanId->toString());
        if (!$exist) {
            UserException::throw("Id pengumuman tidak ditemukan", 3453, 404);
        }
        $this->pengumuman_repository->update(
            $pengumumanId,
            $request->getListEventId(),
            $request->getTitle(),
            $request->getDescription()
        );
    }
}
