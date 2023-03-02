<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Models\Jurnalistik\Member\JurnalistikMember;
use App\Core\Domain\Models\Jurnalistik\Member\JurnalistikMemberId;
use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikTeamId;

interface JurnalistikMemberRepositoryInterface
{
    public function find(JurnalistikMemberId $id): ?JurnalistikMember;

    public function findByUser(UserId $user_id): ?JurnalistikMember;

    public function findAllMember(JurnalistikTeamId $team_id): array;
    public function updateTeamId(UserID $user_id, JurnalistikTeamId $team_id): void;
}
