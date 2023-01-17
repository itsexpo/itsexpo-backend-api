<?php

namespace App\Core\Application\Service\Departemen;

use App\Exceptions\UserException;
use App\Core\Domain\Models\Departemen\Departemen;
use App\Core\Domain\Repository\DepartemenRepositoryInterface;

class DepartemenService
{
    private DepartemenRepositoryInterface $departemen_repository;

    /**
     * @param DepartemenRepositoryInterface
     */
    public function __construct(DepartemenRepositoryInterface $departemen_repository)
    {
        $this->departemen_repository = $departemen_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(?string $fakultas_id): array
    {
        // Mengambil departemen berdasarkan fakultas_id
        if ($fakultas_id) {
            $departemen = $this->departemen_repository->getByFakultasId((int)$fakultas_id);
            if (!count($departemen)) {
                UserException::throw("Departemen Dengan ID Fakultas Tersebut Tidak Ditemukan", 1001, 404);
            }
        }
        // Mengambil seluruh data departemen
        else {
            $departemen = $this->departemen_repository->getAll();

            if (!count($departemen)) {
                UserException::throw("Departemen Tidak Ditemukan", 1002, 404);
            }
        }

        return array_map(function (Departemen $result) {
            return new DepartemenResponse(
                $result->getId(),
                $result->getName()
            );
        }, $departemen);
    }
}
