<?php

namespace App\Core\Application\Service\CekPembayaranKTI;

use Carbon\Carbon;
use App\Exceptions\UserException;
use App\Core\Domain\Models\UserAccount;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Domain\Repository\ListEventRepositoryInterface;
use App\Core\Domain\Repository\PembayaranRepositoryInterface;
use App\Core\Domain\Repository\KTITeamRepositoryInterface;
use App\Core\Domain\Repository\StatusPembayaranRepositoryInterface;
use App\Core\Domain\Repository\KTIMemberRepositoryInterface;
use App\Core\Domain\Models\KTI\Team\KTIJenisKegiatan;
use App\Core\Domain\Models\KTI\Team\KTILombaCategory;

class CekPembayaranKTIService
{
    private KTITeamRepositoryInterface $kti_team_repository;
    private UserRepositoryInterface $user_repository;
    private StatusPembayaranRepositoryInterface $status_pembayaran_repository;
    private PembayaranRepositoryInterface $pembayaran_repository;
    private ListEventRepositoryInterface $list_event_repository;

    public function __construct(
        KTITeamRepositoryInterface $kti_team_repository,
        UserRepositoryInterface $user_repository,
        StatusPembayaranRepositoryInterface $status_pembayaran_repository,
        PembayaranRepositoryInterface $pembayaran_repository,
        ListEventRepositoryInterface $list_event_repository
    ) {
        $this->kti_team_repository = $kti_team_repository;
        $this->user_repository = $user_repository;
        $this->status_pembayaran_repository = $status_pembayaran_repository;
        $this->pembayaran_repository = $pembayaran_repository;
        $this->list_event_repository = $list_event_repository;
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

        $kode_unik = substr($kti_team->getTeamCode(), -3);
        
        $tanggal_pembayaran = Carbon::createFromFormat("Y-m-d H:i:s", $kti_team->getCreatedAt())->addDays(1)->format("Y-m-d H:i:s");
        $harga = 130000; //EarlyBird

        $cek_kuota = true;
        
        return new CekPembayaranKTIResponse(
            $cek_kuota,
            $kode_unik,
            $harga,
            $tanggal_pembayaran
        );
    }
}
