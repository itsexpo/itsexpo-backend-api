<?php

namespace App\Core\Application\Service\RobotInActionAdminConfirm;

use App\Exceptions\UserException;
use App\Core\Domain\Models\Pembayaran\PembayaranId;
use App\Core\Domain\Repository\PembayaranRepositoryInterface;
use App\Core\Domain\Repository\StatusPembayaranRepositoryInterface;

class RobotInActionAdminConfirmService
{
    private PembayaranRepositoryInterface $pembayaran_repository;
    private StatusPembayaranRepositoryInterface $status_pemabayaran_repository;

    /**
     * @param PembayaranRepositoryInterface $pembayaran_repository
     * @param StatusPemabyaranRepositoryInterface $status_pembayaran_repository
     */
    public function __construct(PembayaranRepositoryInterface $pembayaran_repository, StatusPembayaranRepositoryInterface $status_pembayaran_repository)
    {
        $this->pembayaran_repository = $pembayaran_repository;
        $this->status_pemabayaran_repository = $status_pembayaran_repository;
    }

    public function execute(RobotInActionAdminConfirmRequest $request)
    {
        $id = new PembayaranId($request->getPembayaranId());
        $pembayaran = $this->pembayaran_repository->find($id);
 
        if (!$pembayaran) {
            UserException::throw("Pembayaran Tidak Ditemukan", 1001, 404);
        }

        $cekStatusPembayaran = $this->status_pemabayaran_repository->find($request->getStatusPembayaranId());

        if (!$cekStatusPembayaran) {
            UserException::throw("Status Pembayaran Tidak Ditemukan", 1001, 404);
        }

        $this->pembayaran_repository->changeStatusPembayaran($pembayaran->getId(), $request->getStatusPembayaranId());
    }
}
