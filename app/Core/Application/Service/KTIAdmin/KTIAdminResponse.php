<?php

namespace App\Core\Application\Service\KTIAdmin;

use App\Core\Domain\Models\KTI\Team\KTITeam;
use JsonSerializable;

class KTIAdminResponse implements JsonSerializable
{
    private string $ketua_tim;
    private KTITeam $kti_team;
    private string $created_at;
    private string $status_pembayaran;

    /**
     * @param string $ketua_tim
     * @param KTITeam $kti_team
     * @param string $created_at
     * @param string $status_pembayaran
     */
    public function __construct(string $ketua_tim, KTITeam $kti_team, string $created_at, string $status_pembayaran)
    {
        $this->ketua_tim = $ketua_tim;
        $this->kti_team = $kti_team;
        $this->created_at = $created_at;
        $this->status_pembayaran = $status_pembayaran;
    }

    public function jsonSerialize(): array
    {
        return [
          'id_tim' => $this->kti_team->getId()->toString(),
          'ketua_tim' => $this->ketua_tim,
          'nama_tim' => $this->kti_team->getTeamName(),
          'created_at' => $this->created_at,
          'status_pembayaran' => $this->status_pembayaran
        ];
    }
}
