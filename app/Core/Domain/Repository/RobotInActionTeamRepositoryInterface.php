<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\RobotInAction\Team\RobotInActionTeam;
use App\Core\Domain\Models\RobotInAction\Team\RobotInActionTeamId;
use App\Core\Domain\Models\RobotInAction\Team\RobotInActionCompetitionStatus;
use App\Core\Domain\Models\Pembayaran\PembayaranId;

interface RobotInActionTeamRepositoryInterface
{
    public function find(RobotInActionTeamId $id): ?RobotInActionTeam;

    public function persist(RobotInActionTeam $team): void;

    public function incrementJumlahAnggota(string $team_code): void;

    public function decrementJumlahAnggota(string $team_code): void;

    public function findByTeamCode(string $team_code): ?RobotInActionTeam;

    public function countByCompetitionStatus(RobotInActionCompetitionStatus $role): int;

    public function constructFromRows(array $rows): array;

    public function getCreatedAt(RobotInActionTeamId $robot_in_action_team_id): ?string;

    public function updatePembayaran(RobotInActionTeamId $robot_in_action_team_id, PembayaranId $pembayaran_id);
}
