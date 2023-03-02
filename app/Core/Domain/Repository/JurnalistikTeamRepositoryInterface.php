<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikTeam;
use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikTeamId;

interface JurnalistikTeamRepositoryInterface
{
    public function find(JurnalistikTeamId $id): ?JurnalistikTeam;

    public function persist(JurnalistikTeam $team) : void;

    public function incrementJumlahAnggota(string $team_code): void;

    public function decrementJumlahAnggota(string $team_code): void;

    public function findByTeamCode(string $team_code): ?JurnalistikTeam;

    public function countAllTeams(): int;
}
