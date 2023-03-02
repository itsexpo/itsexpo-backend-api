<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikTeam;
use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikTeamId;

interface JurnalistikTeamRepositoryInterface
{
    public function find(JurnalistikTeamId $id): ?JurnalistikTeam;
    public function incrementJumlahAnggota(JurnalistikTeamId $jurnalistik_team_id): void;
    public function decrementJumlahAnggota(JurnalistikTeamId $jurnalistik_team_id): void;
}
