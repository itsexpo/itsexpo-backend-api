<?php

namespace App\Core\Application\Service\JoinTeamJurnalistik;

use App\Exceptions\UserException;
use Illuminate\Support\Facades\DB;
use App\Core\Domain\Repository\RoleRepositoryInterface;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikTeamId;
use App\Core\Domain\Repository\JurnalistikTeamRepositoryInterface;
use App\Core\Domain\Repository\JurnalistikMemberRepositoryInterface;

class JoinTeamJurnalistikService
{
    private JurnalistikMemberRepositoryInterface $jurnalistik_member_repository;
    private JurnalistikTeamRepositoryInterface $jurnalistik_team_repository;
    private UserRepositoryInterface $user_repository;
    private RoleRepositoryInterface $role_repository;

    public function __construct(JurnalistikMemberRepositoryInterface $jurnalistik_member_repository, JurnalistikTeamRepositoryInterface $jurnalistik_team_repository, UserRepositoryInterface $user_repository, RoleRepositoryInterface $role_repository)
    {
        $this->jurnalistik_member_repository = $jurnalistik_member_repository;
        $this->jurnalistik_team_repository = $jurnalistik_team_repository;
        $this->user_repository = $user_repository;
        $this->role_repository = $role_repository;
    }
    public function execute(JoinTeamJurnalistikRequest $request)
    {
        $jurnalistik_member = $this->jurnalistik_member_repository->findByUser($request->getAccount()->getUserId());
        if ($jurnalistik_member == null) {
            UserException::throw("User Not Found", 6006);
        }
        if ($jurnalistik_member->getJurnalistikTeamId() != null) {
            UserException::throw("Already Join to Team", 6004);
        }
        $jurnalistik_team = $this->jurnalistik_team_repository->find(new JurnalistikTeamId($request->getCodeTeam()));

        if ($jurnalistik_team == null) {
            UserException::throw("Jurnalistik Team Not Found", 6007);
        }

        if ($jurnalistik_team->getJumlahAnggota() == 5) {
            UserException::throw("Team is already Full", 6005);
        }

        $user = $this->user_repository->find($request->getAccount()->getUserId());
        $role = $this->role_repository->find($user->getRoleId());
        if ($role->getName() != $jurnalistik_team->getLombaCategory()) {
            UserException::throw("You can join only teams that have the same role", 6003);
        }

        DB::beginTransaction();
        try {
            $this->jurnalistik_member_repository->updateTeamId($request->getAccount()->getUserId(), new JurnalistikTeamId($request->getCodeTeam()));
            $this->jurnalistik_team_repository->incrementJumlahAnggota(new JurnalistikTeamId($request->getCodeTeam()));
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
