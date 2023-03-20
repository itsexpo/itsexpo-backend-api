<?php

namespace App\Core\Application\Service\CekPembayaranJurnalistik;

use Carbon\Carbon;
use App\Exceptions\UserException;
use App\Core\Domain\Models\UserAccount;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Domain\Repository\ListEventRepositoryInterface;
use App\Core\Domain\Repository\PembayaranRepositoryInterface;
use App\Core\Domain\Repository\JurnalistikTeamRepositoryInterface;
use App\Core\Domain\Repository\StatusPembayaranRepositoryInterface;
use App\Core\Domain\Repository\JurnalistikMemberRepositoryInterface;
use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikJenisKegiatan;
use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikLombaCategory;

class CekPembayaranJurnalistikService
{
    private JurnalistikTeamRepositoryInterface $jurnalistik_team_repository;
    private JurnalistikMemberRepositoryInterface $jurnalistik_member_repository;
    private UserRepositoryInterface $user_repository;
    private StatusPembayaranRepositoryInterface $status_pembayaran_repository;
    private PembayaranRepositoryInterface $pembayaran_repository;
    private ListEventRepositoryInterface $list_event_repository;

    public function __construct(
        JurnalistikTeamRepositoryInterface $jurnalistik_team_repository,
        JurnalistikMemberRepositoryInterface $jurnalistik_member_repository,
        UserRepositoryInterface $user_repository,
        StatusPembayaranRepositoryInterface $status_pembayaran_repository,
        PembayaranRepositoryInterface $pembayaran_repository,
        ListEventRepositoryInterface $list_event_repository
    ) {
        $this->jurnalistik_team_repository = $jurnalistik_team_repository;
        $this->jurnalistik_member_repository = $jurnalistik_member_repository;
        $this->user_repository = $user_repository;
        $this->status_pembayaran_repository = $status_pembayaran_repository;
        $this->pembayaran_repository = $pembayaran_repository;
        $this->list_event_repository = $list_event_repository;
    }

    public function execute(UserAccount $account): CekPembayaranJurnalistikResponse
    {
        $user = $this->user_repository->find($account->getUserId());
        if (!$user) {
            UserException::throw("User Tidak Ditemukan", 6009);
        }
        $jurnalistik_member = $this->jurnalistik_member_repository->findByUserId($account->getUserId());
        if (!$jurnalistik_member) {
            UserException::throw("Jurnalistik Team Tidak Ditemukan", 6009);
        }
        $jurnalistik_team = $this->jurnalistik_team_repository->find($jurnalistik_member->getJurnalistikTeamId());
        if (!$jurnalistik_team) {
            UserException::throw("Jurnalistik Team Tidak Ditemukan", 6009);
        }
        $tanggal_pembayaran = Carbon::createFromFormat("Y-m-d H:i:s", $jurnalistik_team->getCreatedAt())->addDays(1)->format("Y-m-d H:i:s");
        $pembayaran = $this->pembayaran_repository->find($jurnalistik_team->getPembayaranId());
        if ($pembayaran && $pembayaran->getStatusPembayaranId() == 1) {
            $tanggal_pembayaran = Carbon::createFromFormat("Y-m-d H:i:s", $jurnalistik_team->getCreatedAt())->addDays(3)->format("Y-m-d H:i:s");
        }
        $kode_unik = substr($jurnalistik_team->getTeamCode(), -3);
        $harga = 300000;
        if ($jurnalistik_team->getJenisKegiatan()->value == 'UMUM') {
            if ($user->getRoleId() == 4) {
                $harga = 125000;
            } else {
                $harga = 150000;
            }
        }
        $cek_kuota = true;
        if ($jurnalistik_team->getJenisKegiatan()->value == 'KHUSUS') {
            $count = $this->jurnalistik_team_repository->countTeamWithJenis(JurnalistikJenisKegiatan::KHUSUS);
            if ($count >= 10) {
                $cek_kuota = false;
            }
        } elseif ($jurnalistik_team->getJenisKegiatan()->value == 'UMUM') {
            if ($user->getRoleId() == 4) {
                $count = $this->jurnalistik_team_repository->countTeamWithJenisAndCategory(JurnalistikJenisKegiatan::KHUSUS, JurnalistikLombaCategory::BLOGGER);
                if ($count >= 20) {
                    $cek_kuota = false;
                }
            } elseif ($user->getRoleId() == 5) {
                $count = $this->jurnalistik_team_repository->countTeamWithJenisAndCategory(JurnalistikJenisKegiatan::KHUSUS, JurnalistikLombaCategory::TELEVISION);
                if ($count >= 20) {
                    $cek_kuota = false;
                }
            }
        }

        return new CekPembayaranJurnalistikResponse(
            $cek_kuota,
            $kode_unik,
            $harga,
            $tanggal_pembayaran
        );
    }
}
