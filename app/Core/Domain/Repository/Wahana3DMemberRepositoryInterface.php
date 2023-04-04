<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Wahana3D\Member\Wahana3DMember;
use App\Core\Domain\Models\Wahana3D\Member\Wahana3DMemberId;
use App\Core\Domain\Models\Wahana3D\Team\Wahana3DTeamId;

interface Wahana3DMemberRepositoryInterface
{
    public function find(Wahana3DMemberId $id): ?Wahana3DMember;

    public function findByTeamId(Wahana3DTeamId $wahana_team_id): ?array;

    public function findLeadByTeamId(Wahana3DTeamId $wahana_team_id): Wahana3DMember;

    public function findAllMember(Wahana3DTeamId $wahana_team_id): array;

    public function persist(Wahana3DMember $member): void;
}
