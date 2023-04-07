<?php

namespace App\Core\Application\Service\GetUserWahanaSeni;

use JsonSerializable;
use App\Core\Domain\Models\Wahana2D\Wahana2D;

class GetUserWahana2DResponse implements JsonSerializable
{
    private Wahana2D $wahana_2d;
    private ?string $pembayaran_id;
    private ?string $pembayaran_status;
    private string $departemen;

    public function __construct(Wahana2D $wahana_2d, ?string $pembayaran_id, ?string $pembayaran_status, string $departemen)
    {
        $this->wahana_2d = $wahana_2d;
        $this->pembayaran_id = $pembayaran_id;
        $this->pembayaran_status = $pembayaran_status;
        $this->departemen = $departemen;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->wahana_2d->getId(),
            'nama' => $this->wahana_2d->getName(),
            'nrp' => $this->wahana_2d->getNrp()->toString(),
            'departemen' => $this->departemen,
            'kontak' => $this->wahana_2d->getKontak(),
            'ktm' => $this->wahana_2d->getKtm(),
            'status' => $this->wahana_2d->getStatus(),
            'payment' => [
                'id' => $this->pembayaran_id,
                'status' => $this->pembayaran_status
            ]
        ];
    }
}
