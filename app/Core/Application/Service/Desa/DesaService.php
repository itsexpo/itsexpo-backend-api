<?php

namespace App\Core\Application\Service\Desa;

use App\Exceptions\UserException;
use App\Core\Domain\Models\Desa\Desa;
use App\Core\Domain\Repository\DesaRepositoryInterface;

class DesaService
{
    private DesaRepositoryInterface $desa_repository;

    /**
     * @param DesaRepositoryInterface $desa_repository
     */
    public function __construct(DesaRepositoryInterface $desa_repository)
    {
        $this->desa_repository = $desa_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(?string $id_kecamatan): array
    {
        if ($id_kecamatan) {
            // check id_kecamatan
            if (!is_numeric($id_kecamatan)) {
                UserException::throw("id_kecamatan Harus Integer", 1057, 404);
            }

            $id_kecamatan = (int)$id_kecamatan;
            $desa = $this->desa_repository->getByKecamatanId($id_kecamatan);

            if (count($desa) < 1) {
                UserException::throw("Desa Dengan ID Kecamatan Tersebut Tidak Ditemukan", 1058, 404);
            }
            return array_map(function (Desa $result) {
                return new DesaResponse(
                    $result->getId(),
                    $result->getName()
                );
            }, $desa);
        } else {
            $desa = $this->desa_repository->getAll();
            if (count($desa) < 1) {
                UserException::throw("Desa Tidak Ditemukan", 1059, 404);
            }
            return array_map(function (Desa $result) {
                return new DesaResponse(
                    $result->getId(),
                    $result->getName()
                );
            }, $desa);
        }
    }
}
