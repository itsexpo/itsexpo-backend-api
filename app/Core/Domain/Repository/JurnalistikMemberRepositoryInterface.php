<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Models\Jurnalistik\Member\JurnalistikMember;
use App\Core\Domain\Models\Jurnalistik\Member\JurnalistikMemberId;
use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikTeamId;

interface JurnalistikMemberRepositoryInterface
{
    public function find(JurnalistikMemberId $id): ?JurnalistikMember;

    public function findByUserId(UserId $user_id): ?JurnalistikMember;

    public function findAllMember(JurnalistikTeamId $team_id): array;

    public function persist(JurnalistikMember $member): void;
    
    public function updateTeamId(JurnalistikMemberId $personal_id, JurnalistikTeamId $team_id): void;
}
