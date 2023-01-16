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
    public function execute(): array
    {
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
