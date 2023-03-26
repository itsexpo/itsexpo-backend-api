<?php

namespace App\Core\Application\Service\GetKtiAdminDetail;

use JsonSerializable;

class GetKtiAdminDetailTeamMemberResponse implements JsonSerializable
{
    private string $nama;
    private string $ketua;
    private string $no_telp;

    public function __construct(
        string $nama,
        string $ketua,
        string $no_telp
    ) {
        $this->nama = $nama;
        $this->ketua = $ketua;
        $this->no_telp = $no_telp;
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->nama,
            'ketua' => $this->ketua,
            'no_telp' => $this->no_telp,
        ];
    }


    /**
     * Get the value of nama
     */
    public function getName()
    {
        return $this->nama;
    }

    /**
     * Get the value of ketua
     */
    public function getKetua()
    {
        return $this->ketua;
    }


    /**
     * Get the value of no_telp
     */
    public function getNoTelp()
    {
        return $this->no_telp;
    }
}
