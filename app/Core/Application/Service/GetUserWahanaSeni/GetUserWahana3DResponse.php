<?php

namespace App\Core\Application\Service\GetUserWahanaSeni;

use JsonSerializable;

class GetUserWahana3DResponse implements JsonSerializable
{
    private string $id;
    private string $team_name;
    private string $team_code;
    private string $deskripsi_karya;

    private PembayaranObjResponse $pembayaran;
    private array $members;


    public function __construct(string $id, string $team_name, string $team_code, string $deskripsi_karya, PembayaranObjResponse $pembayaran, array $members)
    {
        $this->id = $id;
        $this->team_name = $team_name;
        $this->team_code = $team_code;
        $this->deskripsi_karya = $deskripsi_karya;

        $this->pembayaran = $pembayaran;
        $this->members = $members;
    }
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'team_name' => $this->team_name,
            'team_code' => $this->team_code,
            'deskripsi_karya' => $this->deskripsi_karya,
            'payment' => $this->pembayaran,
            'member' => $this->members
        ];
    }
}
