<?php

namespace App\Core\Application\Service\UpdatePembayaran;

use App\Core\Domain\Models\Pembayaran\Pembayaran;
use App\Core\Domain\Models\Pembayaran\PembayaranId;
use App\Core\Domain\Repository\PembayaranRepositoryInterface;
use App\Exceptions\UserException;
use Carbon\Carbon;

class UpdatePembayaranService
{
    private PembayaranRepositoryInterface $pembayaran_repository;

    public function __construct(PembayaranRepositoryInterface $pembayaran_repository)
    {
        $this->pembayaran_repository = $pembayaran_repository;
    }

    public function execute(UpdatePembayaranRequest $request)
    {
        $pembayaran = $this->pembayaran_repository->find(new PembayaranId($request->getPaymentId()));

        if (!$pembayaran) {
            UserException::throw("Pembayaran tidak bisa ditemukan", 6099);
        }

        if ($pembayaran->getStatusPembayaranId() !== 1) {
            UserException::throw("Gagal mengubah waktu pembayaran", 6099);
        }

        $newPembayaran = new Pembayaran(
            new PembayaranId($request->getPaymentId()),
            $pembayaran->getListBankId(),
            $pembayaran->getListEventId(),
            5,
            $pembayaran->getAtasNama(),
            $pembayaran->getBuktiPembayaranUrl(),
            $pembayaran->getHarga(),
            Carbon::now()->addHours(5)
        );

        $this->pembayaran_repository->persist($newPembayaran);
    }
}
