<?php

namespace App\Core\Application\Service\Wahana3DAdmin;

use App\Core\Domain\Models\Wahana3D\Team\Wahana3DTeam;
use JsonSerializable;

class Wahana3DAdminResponse implements JsonSerializable
{
    private string $nama_ketua;
    private Wahana3DTeam $wahana_3d_team;
    private string $created_at;
    private string $status_pembayaran;

    public function __construct(string $nama_ketua, Wahana3DTeam $wahana_3d_team, string $created_at, string $status_pembayaran)
    {
        $this->nama_ketua = $nama_ketua;
        $this->wahana_3d_team = $wahana_3d_team;
        $this->created_at = $created_at;
        $this->status_pembayaran = $status_pembayaran;
    }

    public function jsonSerialize(): array
    {
        return [
          'id_tim' => $this->wahana_3d_team->getId()->toString(),
          'ketua_tim' => $this->nama_ketua,
          'nama_tim' => $this->wahana_3d_team->getTeamName(),
          'kode_tim' => $this->wahana_3d_team->getTeamCode(),
          'created_at' => $this->created_at,
          'status_pembayaran' => $this->status_pembayaran,
        ];
    }
}
