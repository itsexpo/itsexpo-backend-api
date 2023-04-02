<?php

namespace App\Core\Application\Service\GetRobotInActionAdminDetail;

use JsonSerializable;

class PembayaranObjResponse implements JsonSerializable
{
    private ?string $payment_id;
    private string $payment_status;
    private ?string $payment_image;
    private ?string $payment_atas_nama;
    private ?string $payment_bank;
    private ?string $payment_harga;

    public function __construct(string $payment_status, string $payment_id = null, string $payment_image = null, string $payment_atas_nama = null, string $payment_bank = null, string $payment_harga = null)
    {
        $this->payment_id = $payment_id;
        $this->payment_status = $payment_status;
        $this->payment_image = $payment_image;
        $this->payment_atas_nama = $payment_atas_nama;
        $this->payment_bank = $payment_bank;
        $this->payment_harga = $payment_harga;
    }

    public function jsonSerialize(): array
    {
        return [
            'payment_id' => $this->payment_id,
            'payment_status' => $this->payment_status,
            'payment_image' => $this->payment_image,
            'payment_atas_nama' => $this->payment_atas_nama,
            'payment_bank' => $this->payment_bank,
            'payment_harga' => $this->payment_harga
        ];
    }
}
