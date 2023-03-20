<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\KTI\Team\KTITeam;
use App\Core\Domain\Models\KTI\Team\KTITeamId;
use App\Core\Domain\Models\Pembayaran\PembayaranId;
use App\Core\Domain\Models\User\UserId;

interface KTITeamRepositoryInterface
{
    public function find(KTITeamId $id): ?KTITeam;

    public function findByUserId(UserId $user_id): ?KTITeam;

    public function persist(KTITeam $team): void;
    public function updatePembayaran(KTITeamId $jurnalistik_team_id, PembayaranId $pembayaran_id): void;
}
