<?php

namespace App\Core\Application\Service\GetDataJurnalistik;

use App\Exceptions\UserException;
use App\Core\Domain\Models\UserAccount;
use App\Core\Domain\Repository\JurnalistikMemberRepositoryInterface;
use App\Core\Domain\Repository\JurnalistikTeamRepositoryInterface;
use App\Core\Domain\Models\Jurnalistik\Member\JurnalistikMember;

class GetDataJurnalistikService
{
    private JurnalistikTeamRepositoryInterface $jurnalistik_team_repository;
    private JurnalistikMemberRepositoryInterface $jurnalistik_member_repository;

    public function __construct(JurnalistikMemberRepositoryInterface $jurnalistik_member_repository, JurnalistikTeamRepositoryInterface $jurnalistik_team_repository)
    {
        $this->jurnalistik_member_repository = $jurnalistik_member_repository;
        $this->jurnalistik_team_repository = $jurnalistik_team_repository;
    }

    public function execute(UserAccount $account): GetDataJurnalistikResponse
    {
        $user_jurnalistik_info = $this->jurnalistik_member_repository->findByUser($account->getUserId());
        if (!$user_jurnalistik_info) {
            return UserException::throw("Data tidak ditemukan", 6060, 400);
        }
        $team_data = $this->jurnalistik_team_repository->find($user_jurnalistik_info->getJurnalistikTeamId());
        $member_data = $this->jurnalistik_member_repository->findAllMember($user_jurnalistik_info->getJurnalistikTeamId());

        $members_array = array_map(function (JurnalistikMember $member) {
            return new MembersResponse($member);
        }, $member_data);

        $response = new GetDataJurnalistikResponse($team_data, $members_array, $user_jurnalistik_info);

        return $response;
    }
}
