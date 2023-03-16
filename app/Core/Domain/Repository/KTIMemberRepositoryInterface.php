<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\KTI\Member\KTIMember;
use App\Core\Domain\Models\KTI\Member\KTIMemberId;
use App\Core\Domain\Models\KTI\Team\KTITeamId;

interface KTIMemberRepositoryInterface
{
    public function find(KTIMemberId $id): ?KTIMember;

    public function findByTeamId(KTITeamId $kti_team_id): ?array;

    public function findLeadByTeamId(KTITeamId $kti_team_id): ?KTIMember;

    public function persist(KTIMember $member): void;
}
