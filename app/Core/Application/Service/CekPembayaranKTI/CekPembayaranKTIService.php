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
    private KTIMemberRepositoryInterface $kti_member_repository;
    private UserRepositoryInterface $user_repository;
    private StatusPembayaranRepositoryInterface $status_pembayaran_repository;
    private PembayaranRepositoryInterface $pembayaran_repository;
    private ListEventRepositoryInterface $list_event_repository;

    public function __construct(
        KTITeamRepositoryInterface $kti_team_repository,
        KTIMemberRepositoryInterface $kti_member_repository,
        UserRepositoryInterface $user_repository,
        StatusPembayaranRepositoryInterface $status_pembayaran_repository,
        PembayaranRepositoryInterface $pembayaran_repository,
        ListEventRepositoryInterface $list_event_repository
    ) {
        $this->kti_team_repository = $kti_team_repository;
        $this->kti_member_repository = $kti_member_repository;
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
        $kti_member = $this->kti_member_repository->findByUserId($account->getUserId());
        if (!$kti_member) {
            UserException::throw("KTI Team Tidak Ditemukan", 6009);
        }
        $kti_team = $this->kti_team_repository->find($kti_member->getKTITeamId());
        if (!$kti_team) {
            UserException::throw("KTI Team Tidak Ditemukan", 6009);
        }
        $tanggal_pembayaran = Carbon::createFromFormat("Y-m-d H:i:s", $kti_team->getCreatedAt())->addDays(1)->format("Y-m-d H:i:s");
        $kode_unik = substr($kti_team->getTeamCode(), -3);
        $harga = 300000;
        if ($kti_team->getJenisKegiatan()->value == 'UMUM') {
            if ($user->getRoleId() == 4) {
                $harga = 125000;
            } else {
                $harga = 150000;
            }
        }
        $cek_kuota = true;
        if ($kti_team->getJenisKegiatan()->value == 'KHUSUS') {
            $count = $this->kti_team_repository->countTeamWithJenis(KTIJenisKegiatan::KHUSUS);
            if ($count >= 10) {
                $cek_kuota = false;
            }
        } elseif ($kti_team->getJenisKegiatan()->value == 'UMUM') {
            if ($user->getRoleId() == 4) {
                $count = $this->kti_team_repository->countTeamWithJenisAndCategory(KTIJenisKegiatan::KHUSUS, KTILombaCategory::BLOGGER);
                if ($count >= 20) {
                    $cek_kuota = false;
                }
            } elseif ($user->getRoleId() == 5) {
                $count = $this->kti_team_repository->countTeamWithJenisAndCategory(KTIJenisKegiatan::KHUSUS, KTILombaCategory::TELEVISION);
                if ($count >= 20) {
                    $cek_kuota = false;
                }
            }
        }

        return new CekPembayaranKTIResponse(
            $cek_kuota,
            $kode_unik,
            $harga,
            $tanggal_pembayaran
        );
    }
}
