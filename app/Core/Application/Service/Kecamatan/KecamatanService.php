<?php

namespace App\Core\Application\Service\Kecamatan;

use App\Exceptions\UserException;
use App\Core\Domain\Models\Kecamatan\Kecamatan;
use App\Core\Domain\Repository\KecamatanRepositoryInterface;

class KecamatanService
{
    private $kecamatan_repository;

    /**
     * @param KecamatanRepositoryInterface $kecamatan_repository
     */
    public function __construct(KecamatanRepositoryInterface $kecamatan_repository)
    {
        $this->kecamatan_repository = $kecamatan_repository;
    }

    public function Execute(KecamatanRequest $input): array
    {
        $kabupaten = $input->getKabupatenId();

        if (strlen($kabupaten) < 1) {
            $kecamatan = $this->kecamatan_repository->getAll();
        } else {
            $kecamatan = $this->kecamatan_repository->getByKabupatenId($kabupaten);
        }
        if (count($kecamatan) < 1) {
            UserException::throw("Kecamatan Tidak Ditemukan", 6969, 404);
        }
        return array_map(function (Kecamatan $result) {
            return new KecamatanResponse(
                $result->getId(),
                $result->getName()
            );
        }, $kecamatan);
    }
}
