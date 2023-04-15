<?php

namespace App\Core\Application\Service\GetWahana3DAdminDetail;

use JsonSerializable;

class GetWahana3DAdminDetailTeamMemberResponse implements JsonSerializable
{
    private string $nama;
    private bool $ketua;
  
    public function __construct(string $nama, bool $ketua)
    {
        $this->nama = $nama;
        $this->ketua = $ketua;
    }

    public function jsonSerialize(): array
    {
        return [
          'name' => $this->nama,
          'ketua' => $this->ketua
        ];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->nama;
    }

    /**
     * @return bool
     */
    public function getKetua(): bool
    {
        return $this->ketua;
    }
}
