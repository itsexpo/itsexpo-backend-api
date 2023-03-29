<?php

namespace App\Core\Application\Service\CekPembayaranKTI;

use Carbon\Carbon;
use App\Exceptions\UserException;
use App\Core\Domain\Models\UserAccount;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Domain\Repository\PembayaranRepositoryInterface;
use App\Core\Domain\Repository\KTITeamRepositoryInterface;

class CekPembayaranKTIService
{
    private KTITeamRepositoryInterface $kti_team_repository;
    private UserRepositoryInterface $user_repository;
    private PembayaranRepositoryInterface $pembayaran_repository;

    public function __construct(
        KTITeamRepositoryInterface $kti_team_repository,
        UserRepositoryInterface $user_repository,
        PembayaranRepositoryInterface $pembayaran_repository
    ) {
        $this->kti_team_repository = $kti_team_repository;
        $this->user_repository = $user_repository;
        $this->pembayaran_repository = $pembayaran_repository;
    }

    public function execute(UserAccount $account): CekPembayaranKTIResponse
    {
        $user = $this->user_repository->find($account->getUserId());
        if (!$user) {
            UserException::throw("User Tidak Ditemukan", 6009);
        }
        $kti_team = $this->kti_team_repository->findByUserId($account->getUserId());
        if (!$kti_team) {
            UserException::throw("KTI Team Tidak Ditemukan", 6009);
        }

        $pembayaran = $this->pembayaran_repository->find($kti_team->getPembayaranId());
        if (!$pembayaran) {
            UserException::throw("Data pembayaran Tidak Ditemukan", 6009);
        }

        $tanggal_pembayaran = $pembayaran->getDeadline()->toDateTimeString();

        if (Carbon::now() >= $pembayaran->getDeadline()) {
            $updatePembayaran = $pembayaran->update(
                $pembayaran->getId(),
                $pembayaran->getListBankId(),
                $pembayaran->getListEventId(),
                1,
                $pembayaran->getAtasNama(),
                $pembayaran->getBuktiPembayaranUrl(),
                $pembayaran->getHarga(),
                $pembayaran->getDeadline()
            );
            $this->pembayaran_repository->persist($updatePembayaran);
            $data = [
                'payment_id' => $pembayaran->getid()->tostring()
            ];
            userexception::throw("sesi pembayaran telah habis", 6009, 400, $data);
        }

        $kode_unik = substr($kti_team->getTeamCode(), -3);
        
        $tanggal_pembayaran = Carbon::createFromFormat("Y-m-d H:i:s", $kti_team->getCreatedAt())->addDays(1)->format("Y-m-d H:i:s");
        $harga = 130000; //EarlyBird

        $cek_kuota = true;
        
        return new CekPembayaranKTIResponse(
            $cek_kuota,
            $kode_unik,
            $harga,
            $tanggal_pembayaran,
            $pembayaran->getId()->toString()
        );
    }
}
