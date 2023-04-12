<?php

namespace App\Core\Application\Service\Wahana2DAdmin;

use JsonSerializable;

class Wahana2DAdminResponse implements JsonSerializable
{
    private string $name;
    private string $created_at;
    private string $status_pembayaran;

    public function __construct(string $name, string $created_at, string $status_pembayaran)
    {
        $this->name = $name;
        $this->status_pembayaran = $status_pembayaran;
        $this->created_at = $created_at;
    }
    public function jsonSerialize(): array
    {
        return [
            'nama' => $this->name,
            'status_pembayaran' => $this->status_pembayaran,
            'created_at' => $this->created_at,
        ];
    }
}
