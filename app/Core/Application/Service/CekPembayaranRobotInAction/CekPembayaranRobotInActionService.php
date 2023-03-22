<?php

namespace App\Core\Application\Service\CekPembayaranRobotInAction;

use Carbon\Carbon;
use App\Exceptions\UserException;
use App\Core\Domain\Models\UserAccount;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Domain\Repository\PembayaranRepositoryInterface;
use App\Core\Domain\Repository\RobotInActionTeamRepositoryInterface;
use App\Core\Domain\Repository\RobotInActionMemberRepositoryInterface;
use App\Core\Domain\Models\RobotInAction\Team\RobotInActionCompetitionStatus;

class CekPembayaranRobotInActionService
{
    private RobotInActionTeamRepositoryInterface $robotInAction_team_repository;
    private RobotInActionMemberRepositoryInterface $robotInAction_member_repository;
    private UserRepositoryInterface $user_repository;
    private PembayaranRepositoryInterface $pembayaran_repository;


    public function __construct(
        RobotInActionTeamRepositoryInterface $robotInAction_team_repositor,
        RobotInActionMemberRepositoryInterface $robotInAction_member_repository,
        UserRepositoryInterface $user_repository,
        PembayaranRepositoryInterface $pembayaran_repository,
    ) {
        $this->robotInAction_team_repository = $robotInAction_team_repositor;
        $this->robotInAction_member_repository = $robotInAction_member_repository;
        $this->user_repository = $user_repository;
        $this->pembayaran_repository = $pembayaran_repository;
    }

    public function execute(UserAccount $account): CekPembayaranRobotInActionResponse
    {
        $user = $this->user_repository->find($account->getUserId());
        if (!$user) {
            UserException::throw("User Tidak Ditemukan", 6009);
        }
        $robotInAction_member = $this->robotInAction_member_repository->findByUserId($account->getUserId());
        if (!$robotInAction_member) {
            UserException::throw("Jurnalistik Team Tidak Ditemukan", 6009);
        }
        $robotInAction_team = $this->robotInAction_team_repository->find($robotInAction_member->getRobotInActionTeamId());
        if (!$robotInAction_team) {
            UserException::throw("Jurnalistik Team Tidak Ditemukan", 6009);
        }
        $tanggal_pembayaran = Carbon::createFromFormat("Y-m-d H:i:s", $robotInAction_team->getCreatedAt())->addDays(1)->format("Y-m-d H:i:s");
        $pembayaran = $this->pembayaran_repository->find($robotInAction_team->getPembayaranId());
        if ($pembayaran && $pembayaran->getStatusPembayaranId() == 1) {
            $tanggal_pembayaran = Carbon::createFromFormat("Y-m-d H:i:s", $robotInAction_team->getCreatedAt())->addDays(3)->format("Y-m-d H:i:s");
        }
        $kode_unik = substr($robotInAction_team->getTeamCode(), -3);
        $harga = 0;

        $competition_status = $robotInAction_team->getCompetitionStatus();
        if ($competition_status == RobotInActionCompetitionStatus::from('BENTENGAN')) {
            $harga = 175000;
        } else {
            $harga = 150000;
        }

        $cek_kuota = true;
        $LINE_TRACER = 100;
        $BENTENGAN = 100;
        if ($competition_status == RobotInActionCompetitionStatus::LINE_TRACER) {
            $count = $this->robotInAction_team_repository->countByCompetitionStatus($competition_status);
            if ($count >= $LINE_TRACER) {
                UserException::throw("Kompetisi LINE TRACER Sudah Penuh", 6096);
            }
        } else {
            $count = $this->robotInAction_team_repository->countByCompetitionStatus($competition_status);
            if ($count >= $BENTENGAN) {
                UserException::throw("Kompetisi BENTENGAN Sudah Penuh", 6097);
            }
        }


        return new CekPembayaranRobotInActionResponse(
            $cek_kuota,
            $kode_unik,
            $harga,
            $tanggal_pembayaran
        );
    }
}