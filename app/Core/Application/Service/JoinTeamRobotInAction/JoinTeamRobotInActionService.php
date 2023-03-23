<?php

namespace App\Core\Application\Service\JoinTeamRobotInAction;

use App\Core\Domain\Models\UserAccount;
use App\Exceptions\UserException;
use App\Core\Domain\Repository\RoleRepositoryInterface;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Domain\Repository\RobotInActionMemberRepositoryInterface;
use App\Core\Domain\Repository\RobotInActionTeamRepositoryInterface;

class JoinTeamRobotInActionService
{
    private RobotInActionMemberRepositoryInterface $robotik_member_repository;
    private RobotInActionTeamRepositoryInterface $robotik_team_repository;
    private UserRepositoryInterface $user_repository;
    private RoleRepositoryInterface $role_repository;

    public function __construct(RobotInActionMemberRepositoryInterface $robotik_member_repository, RobotInActionTeamRepositoryInterface $robotik_team_repository, UserRepositoryInterface $user_repository, RoleRepositoryInterface $role_repository)
    {
        $this->robotik_member_repository = $robotik_member_repository;
        $this->robotik_team_repository = $robotik_team_repository;
        $this->user_repository = $user_repository;
        $this->role_repository = $role_repository;
    }
    public function execute(JoinTeamRobotInActionRequest $request, UserAccount $account)
    {
        $robotik_member = $this->robotik_member_repository->findByUserId($account->getUserId());
        if (!$robotik_member) {
            UserException::throw("Robot In Action Team Tidak Ditemukan", 6016);
        }
        if ($robotik_member->getRobotInActionTeamId()->toString()) {
            UserException::throw("User Sudah Join Team", 6004);
        }
        $robotik_team = $this->robotik_team_repository->findByTeamCode($request->getCodeTeam());

        if ($robotik_team == null) {
            UserException::throw("Robot In Action Team Tidak Ditemukan", 6017);
        }

        if ($robotik_team->getJumlahAnggota() >= 3) {
            UserException::throw("Jumlah Team Sudah Penuh", 6005);
        }
        
        $this->robotik_member_repository->updateTeamId($robotik_member->getId(), $robotik_team->getId());
        $this->robotik_team_repository->incrementJumlahAnggota($request->getCodeTeam());
    }
}
