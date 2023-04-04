<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Models\Wahana3D\Team\Wahana3DTeam;
use App\Core\Domain\Models\Wahana3D\Team\Wahana3DTeamId;

interface Wahana3DTeamRepositoryInterface
{
    public function find(Wahana3DTeamId $id): ?Wahana3DTeam;

    public function findByUserId(UserId $user_id): ?Wahana3DTeam;

    public function persist(Wahana3DTeam $team): void;

    public function countAllTeams(): int;
}
