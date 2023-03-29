<?php

namespace App\Infrastrucutre\Repository;

use App\Core\Domain\Models\RobotInAction\Team\RobotInActionCompetitionStatus;
use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\RobotInAction\Team\RobotInActionTeam;
use App\Core\Domain\Models\RobotInAction\Team\RobotInActionTeamId;
use App\Core\Domain\Repository\RobotInActionTeamRepositoryInterface;
use App\Core\Domain\Models\Pembayaran\PembayaranId;

class SqlRobotInActionTeamRepository implements RobotInActionTeamRepositoryInterface
{
    public function find(RobotInActionTeamId $robot_in_action_team_id): ?RobotInActionTeam
    {
        $row = DB::table('robot_in_action_team')->where('id', $robot_in_action_team_id->toString())->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    public function getCreatedAt(RobotInActionTeamId $robot_in_action_team_id): ?string
    {
        $row = DB::table('robot_in_action_team')->where('id', $robot_in_action_team_id->toString())->first();
        if (!$row) {
            return null;
        }
        return $row->created_at;
    }

    public function findByTeamCode(string $team_code): ?RobotInActionTeam
    {
        $row = DB::table('robot_in_action_team')->where('team_code', $team_code)->first();
        if (!$row) {
            return null;
        }
        return $this->constructFromRows([$row])[0];
    }

    public function persist(RobotInActionTeam $team): void
    {
        DB::table('robot_in_action_team')->upsert([
            'id' => $team->getId()->toString(),
            'pembayaran_id' => $team->getPembayaranId()->toString(),
            'team_name' => $team->getTeamName(),
            'team_code' => $team->getTeamCode(),
            'competition_status' => $team->getCompetitionStatus()->value,
            'deskripsi_karya' => $team->getDeskripsiKarya(),
            'jumlah_anggota' => $team->getJumlahAnggota(),
            'team_status' => $team->getTeamStatus(),
        ], 'id');
    }

    public function incrementJumlahAnggota(string $team_code): void
    {
        $robot_in_action_team = DB::table('robot_in_action_team')->where('team_code', $team_code);
        if (!$robot_in_action_team->first()) {
            return;
        }
        $robot_in_action_team->update(
            ['jumlah_anggota' => (int)$robot_in_action_team->first()->jumlah_anggota + 1]
        );
    }

    public function decrementJumlahAnggota(string $team_code): void
    {
        $robot_in_action = DB::table('robot_in_action_team')->where('team_code', $team_code);
        if (!$robot_in_action->first()) {
            return;
        }
        $robot_in_action->update(
            ['jumlah_anggota' => (int)$robot_in_action->first()->jumlah_anggota - 1]
        );
    }

    public function constructFromRows(array $rows): array
    {
        $robot_in_action_team = [];
        foreach ($rows as $row) {
            $robot_in_action_team[] = new RobotInActionTeam(
                new RobotInActionTeamId($row->id),
                new PembayaranId($row->pembayaran_id),
                $row->team_name,
                $row->team_code,
                RobotInActionCompetitionStatus::from($row->competition_status),
                $row->deskripsi_karya,
                $row->jumlah_anggota,
                $row->team_status,
                $row->created_at
            );
        }
        return $robot_in_action_team;
    }

    public function countAllTeams(): int
    {
        return DB::table('robot_in_action_team')->count();
    }

    public function countByCompetitionStatus(RobotInActionCompetitionStatus $role): int
    {
        $newest = DB::table('robot_in_action_team')->where('competition_status', '=', $role->value)
            ->count();

        if ($newest === null) {
            return 0;
        }

        return $newest;
    }

    public function updatePembayaran(RobotInActionTeamId $robot_in_action_team_id, PembayaranId $pembayaran_id): void
    {
        $robot_in_action_team = DB::table('robot_in_action_team')->where('id', $robot_in_action_team_id->toString());
        if (!$robot_in_action_team->first()) {
            return;
        }
        $robot_in_action_team->update(
            ['pembayaran_id' => $pembayaran_id->toString()]
        );
    }

    public function findByPembayaranId(PembayaranId $pembayaran_id): RobotInActionTeam
    {
        $row = DB::table('robot_in_action_team')->where('pembayaran_id', $pembayaran_id->toString())->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }
}
