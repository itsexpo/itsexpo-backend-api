<?php

namespace App\Core\Application\Service\JoinTeamJurnalistik;

use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikLombaCategory;
use App\Core\Domain\Models\UserAccount;
use App\Exceptions\UserException;
use App\Core\Domain\Repository\RoleRepositoryInterface;
use App\Core\Domain\Repository\UserRepositoryInterface;
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
    public function execute(JoinTeamJurnalistikRequest $request, UserAccount $account)
    {
        $jurnalistik_member = $this->jurnalistik_member_repository->findByUserId($account->getUserId());
        if (!$jurnalistik_member) {
            UserException::throw("Jurnalistik Team Tidak Ditemukan", 6016);
        }
        if ($jurnalistik_member->getJurnalistikTeamId()->toString()) {
            UserException::throw("User Sudah Join Team", 6004);
        }
        $jurnalistik_team = $this->jurnalistik_team_repository->findByTeamCode($request->getCodeTeam());

        if ($jurnalistik_team == null) {
            UserException::throw("Jurnalistik Team Tidak Ditemukan", 6017);
        }

        if ($jurnalistik_team->getJumlahAnggota() >= 5) {
            UserException::throw("Jumlah Team Sudah Penuh", 6005);
        }

        $user = $this->user_repository->find($account->getUserId());
        $role = $this->role_repository->find($user->getRoleId());
        if ($role->getName() == 'SMA/Sederajat') {
            if ($jurnalistik_team->getLombaCategory() != JurnalistikLombaCategory::BLOGGER) {
                UserException::throw("Role Anda Tidak Diperbolehkan Mengikuti Kategori Lomba yang Dipilih Team", 6003);
            }
        } elseif ($role->getName() == 'Mahasiswa') {
            if ($jurnalistik_team->getLombaCategory() != JurnalistikLombaCategory::TELEVISION) {
                UserException::throw("Role Anda Tidak Diperbolehkan Mengikuti Kategori Lomba yang Dipilih Team", 6003);
            }
        } else {
            UserException::throw("Role Anda Tidak Diperbolehkan Mengikuti Lomba Ini", 6002);
        }
        
        $this->jurnalistik_member_repository->updateTeamId($jurnalistik_member->getId(), $jurnalistik_team->getId());
        $this->jurnalistik_team_repository->incrementJumlahAnggota($request->getCodeTeam());
    }
}
