<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Pembayaran\PembayaranId;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Models\Wahana3D\Team\Wahana3DTeam;
use App\Core\Domain\Models\Wahana3D\Team\Wahana3DTeamId;
use Illuminate\Database\Query\Builder;

interface Wahana3DTeamRepositoryInterface
{
    public function find(Wahana3DTeamId $id): ?Wahana3DTeam;

    public function findByUserId(UserId $user_id): ?Wahana3DTeam;

    public function findByPembayaranId(PembayaranId $pembayaran_id): ?Wahana3DTeam;

    public function constructFromRows(array $rows): array;

    public function persist(Wahana3DTeam $team): void;

    public function getCreatedAt(Wahana3DTeamId $wahana_3d_team_id): ?string;

    public function constructFromRows(array $rows): array;

    public function countAllTeams(): int;

    public function getTeams(): Builder;

    public function getTotalTimCount(): int;

    public function getPembayaranCount(int $status_pembayaran): int;
    
    public function getAwaitingPaymentCount(): int;

    public function getFilter(Builder $wahana_team, ?array $filter): void;

    public function getSearch(Builder $wahana_team, ?string $search): void;
}
