<?php

namespace App\Core\Application\Service\DeletePengumuman;

use App\Exceptions\UserException;
use App\Core\Domain\Models\Pengumuman\PengumumanId;
use App\Core\Domain\Repository\PengumumanRepositoryInterface;

class DeletePengumumanService
{
    private PengumumanRepositoryInterface $pengumuman_repository;

    public function __construct(PengumumanRepositoryInterface $pengumuman_repository)
    {
        $this->pengumuman_repository = $pengumuman_repository;
    }

    public function execute(DeletePengumumanRequest $request)
    {
        $id = new PengumumanId($request->getPengumumanId());
        $exist = $this->pengumuman_repository->getById($id->toString());
        if (!$exist) {
            UserException::throw("Id pengumuman tidak ditemukan", 3453, 404);
        }
        $this->pengumuman_repository->delete(
            $id
        );
    }
}
