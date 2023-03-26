<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\KTI\Team\KTITeam;
use App\Core\Domain\Models\KTI\Team\KTITeamId;
use App\Core\Domain\Models\Pembayaran\PembayaranId;
use App\Core\Domain\Models\User\UserId;
use Illuminate\Database\Query\Builder;

interface KTITeamRepositoryInterface
{
    public function find(KTITeamId $id): ?KTITeam;

    public function findByUserId(UserId $user_id): ?KTITeam;

    public function persist(KTITeam $team): void;

    public function constructFromRows(array $rows): array;

    public function getCreatedAt(KTITeamId $kti_team_id): ?string;

    public function getTeams(): Builder;

    public function getTotalTimCount(): int;

    public function getPembayaranRevisiCount(int $status_pembayaran): int;

    public function getPembayaranGagalCount(int $status_pembayaran): int;

    public function getPembayaranSuccessCount(int $status_pembayaran): int;

    public function getAwaitingVerificationCount(int $status_pembayaran): int;

    public function getAwaitingPaymentCount(int $status_pembayaran): int;

    public function getFilter(Builder $kti_team, ?array $filter): void;

    public function getSearch(Builder $kti_team, ?string $search): void;
    public function countAllTeams(): int;
    public function updatePembayaran(KTITeamId $jurnalistik_team_id, PembayaranId $pembayaran_id): void;
}
