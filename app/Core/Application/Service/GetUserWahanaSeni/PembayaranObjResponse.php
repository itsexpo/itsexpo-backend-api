<?php

namespace App\Core\Application\Service\GetUserWahanaSeni;

use JsonSerializable;

class PembayaranObjResponse implements JsonSerializable
{
    private ?string $payment_id;
    private string $payment_status;

    public function __construct(string $payment_status, string $payment_id = null)
    {
        $this->payment_id = $payment_id;
        $this->payment_status = $payment_status;
    }

    public function jsonSerialize(): array
    {
        return [
            'payment_id' => $this->payment_id,
            'payment_status' => $this->payment_status,
        ];
    }
}
