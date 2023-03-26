<?php

namespace App\Core\Application\Service\GetKtiAdminDetail;

use JsonSerializable;

class PembayaranObjResponse implements JsonSerializable
{
    private ?string $payment_id;
    private string $payment_status;
    private ?string $payment_image;

    public function __construct(string $payment_status, string $payment_id = null, string $payment_image = null)
    {
        $this->payment_id = $payment_id;
        $this->payment_status = $payment_status;
        $this->payment_image = $payment_image;
    }

    public function jsonSerialize(): array
    {
        return [
            'payment_id' => $this->payment_id,
            'payment_status' => $this->payment_status,
            'payment_image' => $this->payment_image
        ];
    }
}
