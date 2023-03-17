<?php

namespace App\Core\Application\Service\GetAnggotaRobotInAction;

use App\Exceptions\UserException;
use App\Core\Domain\Models\UserAccount;
use App\Core\Domain\Repository\PembayaranRepositoryInterface;
use App\Core\Domain\Repository\RobotInActionMemberRepositoryInterface;
use App\Core\Domain\Repository\RobotInActionTeamRepositoryInterface;
use App\Core\Domain\Repository\StatusPembayaranRepositoryInterface;

class GetAnggotaRobotInActionService
{
    private RobotInActionTeamRepositoryInterface $robotik_team;
    private RobotInActionMemberRepositoryInterface $robotik_member;
    private StatusPembayaranRepositoryInterface $status_pembayaran;
    private PembayaranRepositoryInterface $pembayaran;

    public function __construct(RobotInActionTeamRepositoryInterface $robotik_team, RobotInActionMemberRepositoryInterface $robotik_member, StatusPembayaranRepositoryInterface $status_pembayaran, PembayaranRepositoryInterface $pembayaran)
    {
        $this->robotik_team = $robotik_team;
        $this->robotik_member = $robotik_member;
        $this->status_pembayaran = $status_pembayaran;
        $this->pembayaran = $pembayaran;
    }

    public function execute(UserAccount $account)
    {
        $userid = $account->getUserId();
        $member = $this->robotik_member->findByUserId($userid);

        if (!$member) {
            return UserException::throw("Data Tidak Ditemukan", 6060, 400);
        }

        $team = $this->robotik_team->find($member->getRobotInActionTeamId());

        if (!$team) {
            return UserException::throw("Data Team Tidak Ditemukan", 6060, 400);
        }

        $pemabayaran_tim = $this->pembayaran->find($team->getPembayaranId());

        if (!$pemabayaran_tim) {
            return UserException::throw("Data Pembayaran Tim Tidak Ditemukan", 6060, 400);
        }
        $status_pembayaran_tim = $this->status_pembayaran->find($pemabayaran_tim->getStatusPembayaranId())->getStatus();

        if (!$status_pembayaran_tim) {
            return UserException::throw("Data Status Pembayaran Tidak Ditemukan", 6060, 400);
        }
        $peserta = [];
        $team_members = $this->robotik_member->findAllMember($team->getId());
        foreach ($team_members as $team_member) {
            $peserta[] = new GetAnggotaRobotInActionPesertaResponse(
                $team_member->getId()->toString(),
                $team_member->getName(),
                $team_member->getMemberType() == 'KETUA' ? 'TRUE' : 'FALSE',
                $team_member->getSharePosterUrl(),
                $team_member->getIdCardUrl(),
                $team_member->getFollowSosmedUrl(),
            );
        }

        return new GetAnggotaRobotInActionResponse(
            $team->getId()->toString(),
            $team->getTeamName(),
            $member->getMemberType() == 'KETUA' ? 'TRUE' : 'FALSE',
            $team->getTeamCode(),
            $team->getDeskripsiKarya(),
            $team->getPembayaranId()->toString(),
            $status_pembayaran_tim,
            $peserta,
            $member->getId()->toString(),
            $member->getName(),
            $member->getFollowSosmedUrl(),
            $member->getIdCardUrl(),
            $member->getSharePosterUrl(),
            $member->getAsalSekolah()
        );
    }
}
