<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Jurnalistik\Member\JurnalistikMember;
use App\Core\Domain\Models\Jurnalistik\Member\JurnalistikMemberId;
use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikTeamId;
use App\Core\Domain\Models\User\UserId;

interface JurnalistikMemberRepositoryInterface
{
    public function find(JurnalistikMemberId $id): ?JurnalistikMember;

    public function findByUser(UserId $user_id): ?JurnalistikMember;

    public function findAllMember(JurnalistikTeamId $team_id): array;

    public function persist(JurnalistikMember $member): void;
}
