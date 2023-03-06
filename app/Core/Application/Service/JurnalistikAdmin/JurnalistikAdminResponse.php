<?php

namespace App\Core\Application\Service\JurnalistikAdmin;

use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikTeam;
use JsonSerializable;

class JurnalistikAdminResponse implements JsonSerializable
{
    private string $ketua_tim;
    private JurnalistikTeam $jurnalistik_team;
    private string $created_at;
    private string $status_pembayaran;

    public function __construct(string $ketua_tim, JurnalistikTeam $jurnalistik_team, string $created_at, string $status_pembayaran)
    {
        $this->jurnalistik_team = $jurnalistik_team;
        $this->status_pembayaran = $status_pembayaran;
        $this->created_at = $created_at;
        $this->ketua_tim = $ketua_tim;
    }
    public function jsonSerialize(): array
    {
        return [
            'ketua_tim' => $this->ketua_tim,
            'nama_tim' => $this->jurnalistik_team->getTeamName(),
            'kode_tim' => $this->jurnalistik_team->getTeamCode(),
            'created_at' => $this->created_at,
            'status_pembayaran' => $this->status_pembayaran,
        ];
    }
}
