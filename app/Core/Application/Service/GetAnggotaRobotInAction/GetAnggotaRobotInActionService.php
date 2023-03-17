<?php

namespace App\Core\Application\Service\GetAnggotaRobotInAction;

use App\Core\Application\Service\GetAnggotaRobotInAction\GetAnggotaRobotInActionPesertaResponse;
use App\Core\Application\Service\GetAnggotaRobotInAction\GetAnggotaRobotInActionResponse;
use App\Core\Application\Service\GetDetailRobotik\GetAnggotaRobotikRequest;
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
        $team = $this->robotik_team->find($member->getRobotInActionTeamId());
        $pemabayaran_tim = $this->pembayaran->find($team->getPembayaranId());
        $status_pembayaran_tim = $this->status_pembayaran->find($pemabayaran_tim->getStatusPembayaranId())->getStatus();

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
