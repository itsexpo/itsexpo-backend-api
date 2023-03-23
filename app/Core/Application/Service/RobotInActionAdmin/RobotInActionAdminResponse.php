<?php

namespace App\Core\Application\Service\RobotInActionAdmin;

use App\Core\Domain\Models\RobotInAction\Team\RobotInActionTeam;
use JsonSerializable;

class RobotInActionAdminResponse implements JsonSerializable
{
    private string $ketua_tim;
    private RobotInActionTeam $robot_int_action_team;
    private string $created_at;
    private string $status_pembayaran;

    public function __construct(string $ketua_tim, RobotInActionTeam $robot_int_action_team, string $created_at, string $status_pembayaran)
    {
        $this->robot_int_action_team = $robot_int_action_team;
        $this->status_pembayaran = $status_pembayaran;
        $this->created_at = $created_at;
        $this->ketua_tim = $ketua_tim;
    }
    public function jsonSerialize(): array
    {
        return [
            'id_tim' => $this->robot_int_action_team->getId()->toString(),
            'ketua_tim' => $this->ketua_tim,
            'nama_tim' => $this->robot_int_action_team->getTeamName(),
            'kode_tim' => $this->robot_int_action_team->getTeamCode(),
            'created_at' => $this->created_at,
            'status_pembayaran' => $this->status_pembayaran,
        ];
    }
}
