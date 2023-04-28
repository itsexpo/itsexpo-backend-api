<?php

namespace App\Core\Application\Service\Wahana2DAdmin;

use JsonSerializable;

class Wahana2DAdminResponse implements JsonSerializable
{
    private string $id;
    private string $name;
    private string $created_at;
    private string $status_pembayaran;
    private ?string $status_pengumpulan;

    public function __construct(string $id, string $name, string $created_at, string $status_pembayaran, string $status_pengumpulan = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->status_pembayaran = $status_pembayaran;
        $this->created_at = $created_at;
        $this->status_pengumpulan = $status_pengumpulan;
    }
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'nama' => $this->name,
            'status_pembayaran' => $this->status_pembayaran,
            'status_pengumpulan' => ($this->status_pengumpulan == null ? false : true),
            'created_at' => $this->created_at,
        ];
    }
}
