<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Jurnalistik\Member\JurnalistikMember;
use App\Core\Domain\Models\Jurnalistik\Member\JurnalistikMemberId;

interface JurnalistikMemberRepositoryInterface
{
    public function find(JurnalistikMemberId $id): ?JurnalistikMember;
}
