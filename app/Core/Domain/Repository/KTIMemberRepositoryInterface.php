<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\KTI\Member\KTIMember;
use App\Core\Domain\Models\KTI\Member\KTIMemberId;

interface KTIMemberRepositoryInterface
{
    public function find(KTIMemberId $id): ?KTIMember;

    public function persist(KTIMember $member): void;
}
