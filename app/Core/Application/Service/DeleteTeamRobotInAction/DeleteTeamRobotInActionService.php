<?php

namespace App\Core\Application\Service\DeleteTeamRobotInAction;

use App\Exceptions\UserException;
use App\Core\Domain\Models\UserAccount;
use App\Core\Domain\Models\RobotInAction\Member\RobotInActionMemberId;
use App\Core\Domain\Models\RobotInAction\RobotInActionMemberType;
use App\Core\Domain\Models\RobotInAction\Team\RobotInActionTeamId;
use App\Core\Domain\Repository\RobotInActionTeamRepositoryInterface;
use App\Core\Domain\Repository\RobotInActionMemberRepositoryInterface;

class DeleteTeamRobotInActionService
{
    private RobotInActionTeamRepositoryInterface $robotik_team_repository;
    private RobotInActionMemberRepositoryInterface $robotik_member_repository;

    public function __construct(RobotInActionTeamRepositoryInterface $robotik_team_repository, RobotInActionMemberRepositoryInterface $robotik_member_repository)
    {
        $this->robotik_team_repository = $robotik_team_repository;
        $this->robotik_member_repository = $robotik_member_repository;
    }

    public function execute(DeleteTeamRobotInActionRequest $request, UserAccount $account)
    {
        $robotik_member = $this->robotik_member_repository->find(new RobotInActionMemberId($request->getIdPersonal()));
        if (!$robotik_member) {
            UserException::throw("Member Tidak Terdaftar Menjadi Anggota Team Ini", 6019);
        }

        $executor = $this->robotik_member_repository->findByUserId($account->getUserId());

        if ($executor->getMemberType() != RobotInActionMemberType::KETUA->value) {
            UserException::throw("Hanya Ketua yang Memiliki Akses Untuk Menghapus Data Team", 6006);
        }
        if (!$robotik_member->getRobotInActionTeamId()) {
            UserException::throw("Member Belum Mempunyai Team", 6007);
        }
        $this->robotik_member_repository->updateTeamId($robotik_member->getId(), new RobotInActionTeamId(null));
        $this->robotik_team_repository->decrementJumlahAnggota($request->getCodeTeam());
    }
}
