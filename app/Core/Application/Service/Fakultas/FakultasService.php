<?php

namespace App\Core\Application\Service\Fakultas;

use App\Exceptions\UserException;
use App\Core\Domain\Models\Fakultas\Fakultas;
use App\Core\Domain\Repository\FakultasRepositoryInterface;

class FakultasService
{
    private FakultasRepositoryInterface $fakultas_repository;

    /**
     * @param FakultasRepositoryInterface $fakultas_repository
     */
    public function __construct(FakultasRepositoryInterface $fakultas_repository)
    {
        $this->fakultas_repository = $fakultas_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(): array
    {
        $fakultas = $this->fakultas_repository->getAll();
        if (!count($fakultas)) {
            UserException::throw("Fakultas Tidak Ditemukan", 1010, 404);
        }
        return array_map(function (Fakultas $result) {
            return new FakultasResponse(
                $result->getId(),
                $result->getName(),
                $result->getSingkatan()
            );
        }, $fakultas);
    }
}
