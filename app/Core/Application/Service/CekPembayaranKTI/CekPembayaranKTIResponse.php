<?php

namespace App\Core\Application\Service\CekPembayaranKti;

use JsonSerializable;

class CekPembayaranKtiResponse implements JsonSerializable
{
    private bool $cek_kuota;
    private string $harga;
    private string $tanggal_pembayaran;

    public function __construct(
        bool $cek_kuota,
        string $harga,
        string $tanggal_pembayaran
    ) {
        $this->cek_kuota = $cek_kuota;
        $this->harga = $harga;
        $this->tanggal_pembayaran = $tanggal_pembayaran;
    }

    public function jsonSerialize(): array
    {
        return [
            'cek_kuota' => $this->cek_kuota,
            'harga' => $this->harga,
            'tanggal_pembayaran' => $this->tanggal_pembayaran,
        ];
    }
}
