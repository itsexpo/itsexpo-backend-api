<?php

namespace App\Core\Application\Service\RegisterJurnalistikTeam;

use JsonSerializable;

class RegisterJurnalistikTeamResponse implements JsonSerializable
{
    public function jsonSerialize(): array
    {
        return[
          "success" => true,
          "message" => "Team telah berhasil dibuat",
        ];
    }
}
