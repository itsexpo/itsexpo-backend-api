<?php

namespace App\Core\Application\Service\GetJurnalistikAdminDetail;

use JsonSerializable;

class PembayaranObjResponse implements JsonSerializable
{
    private string $payment_status;
    private string $payment_image;

    public function __construct(string $payment_status, string $payment_image)
    {
        $this->payment_status = $payment_status;
        $this->payment_image = $payment_image;
    }

    public function jsonSerialize(): array
    {
        return [
            'payment_status' => $this->payment_status,
            'payment_image' => $this->payment_image
        ];
    }
}
