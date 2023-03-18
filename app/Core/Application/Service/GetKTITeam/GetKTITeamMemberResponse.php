<?php

namespace App\Core\Application\Service\GetKTITeam;

use JsonSerializable;

class GetKTITeamMemberResponse implements JsonSerializable
{
    private string $nama;
    private string $no_telp;

    public function __construct(string $nama, string $no_telp) {
        $this->nama = $nama;
        $this->no_telp = $no_telp;
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->nama,
            'no_telp' => $this->no_telp,
        ];
    }
}
