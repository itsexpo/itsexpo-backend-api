<?php

namespace App\Core\Application\Service\GetDataJurnalistik;

use App\Core\Domain\Models\Jurnalistik\Member\JurnalistikMember;
use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikTeam;

use JsonSerializable;

class GetDataJurnalistikResponse implements JsonSerializable
{
    private JurnalistikTeam $jurnalistik_team;
    private JurnalistikMember $personal;
    private array $members;

    public function __construct(JurnalistikTeam $jurnalistik_team, array $members, JurnalistikMember $personal)
    {
        $this->jurnalistik_team = $jurnalistik_team;
        $this->members = $members;
        $this->personal = $personal;
    }

    public function jsonSerialize(): array
    {
        $response = [
            'id_tim' => $this->jurnalistik_team->getId()->toString(),
            'name_tim' => $this->jurnalistik_team->getTeamName(),
            'code_tim' => $this->jurnalistik_team->getTeamCode(),
            'status' => [
                'status' => $this->jurnalistik_team->getTeamStatus(),
                'pembayaran_id' => $this->jurnalistik_team->getPemBayaranId()->toString()
            ],
            'peserta' => $this->members,
            'personal' => [
                'id' => $this->personal->getId()->toString(),
                'user_id' => $this->personal->getUserId()->toString(),
                'nama' => $this->personal->getName(),
                'provinsi' => $this->personal->getProvinsiId(),
                'kabupaten' => $this->personal->getKabupatenId(),
                'asal_instansi' => $this->personal->getAsalInstansi()
            ]

        ];
        return $response;
    }
}
