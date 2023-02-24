<?php

namespace App\Core\Application\Service\AddPengumuman;

use App\Core\Domain\Models\Pengumuman\Pengumuman;
use App\Core\Domain\Repository\PengumumanRepositoryInterface;

class AddPengumumanService
{
    private PengumumanRepositoryInterface $pengumuman_repository;

    /**
     * @param PengumumanRepositoryInterface $pengumuman_respository
     */

    public function __construct(PengumumanRepositoryInterface $pengumuman_repository)
    {
        $this->pengumuman_repository = $pengumuman_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(AddPengumumanRequest $request)
    {
        $pengumuman = Pengumuman::create(
            $request->getListEventId(),
            $request->getTitle(),
            $request->getDescription()
        );

        $this->pengumuman_repository->persist($pengumuman);
    }
}
