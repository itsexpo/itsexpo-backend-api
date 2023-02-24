<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikTeam;
use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikTeamId;

interface JurnalistikTeamRepositoryInterface
{
    public function find(JurnalistikTeamId $id): ?JurnalistikTeam;
}
