<?php

namespace App\Core\Application\Service\RegisterJurnalistikMember;

class RegisterJurnalistikMemberResponse
{
    public function jsonSerialize(): array
    {
        return[
          "success" => true,
          "message" => "Member berhasil ditambahkan",
        ];
    }
}
