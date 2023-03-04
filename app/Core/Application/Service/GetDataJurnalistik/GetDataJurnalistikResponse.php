<?php

namespace App\Core\Application\Service\GetDataJurnalistik;

use App\Core\Domain\Models\Jurnalistik\JurnalistikMemberType;
use App\Core\Domain\Models\Jurnalistik\Member\JurnalistikMember;
use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikTeam;

use JsonSerializable;

class GetDataJurnalistikResponse implements JsonSerializable
{
    private JurnalistikTeam $jurnalistik_team;
    private JurnalistikMember $personal;
    private string $kabupaten;
    private string $provinsi;
    private array $members;
    private string $pembayaran;

    public function __construct(JurnalistikTeam $jurnalistik_team, array $members, JurnalistikMember $personal, string $provinsi, string $kabupaten, string $pembayaran)
    {
        $this->jurnalistik_team = $jurnalistik_team;
        $this->members = $members;
        $this->personal = $personal;
        $this->provinsi = $provinsi;
        $this->kabupaten = $kabupaten;
        $this->pembayaran = $pembayaran;
    }

    private function cekKetua(): bool
    {
        if ($this->personal->getMemberType() == JurnalistikMemberType::KETUA) {
            return true;
        }
        return false;
    }
    
    public function jsonSerialize(): array
    {
        $response = [
            'id_tim' => $this->jurnalistik_team->getId()->toString(),
            'name_tim' => $this->jurnalistik_team->getTeamName(),
            'ketua_tim' => $this->cekKetua(),
            'code_tim' => $this->jurnalistik_team->getTeamCode(),
            'status' => [
                'status' => $this->jurnalistik_team->getTeamStatus(),
                'pembayaran' => $this->pembayaran,
            ],
            'category_jurnalistik' => $this->jurnalistik_team->getLombaCategory(),
            'peserta' => $this->members,
            'personal' => [
                'id' => $this->personal->getId()->toString(),
                'user_id' => $this->personal->getUserId()->toString(),
                'nama' => $this->personal->getName(),
                'provinsi' => $this->provinsi,
                'kabupaten' => $this->kabupaten,
                'asal_instansi' => $this->personal->getAsalInstansi()
            ]

        ];
        return $response;
    }
}
