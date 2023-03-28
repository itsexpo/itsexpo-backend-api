<?php

namespace App\Core\Application\Service\CekPembayaranJurnalistik;

use JsonSerializable;

class CekPembayaranJurnalistikResponse implements JsonSerializable
{
    private bool $cek_kuota;
    private string $kode_unik;
    private string $harga;
    private string $tanggal_pembayaran;
    private string $payment_id;

    public function __construct(
        bool $cek_kuota,
        string $kode_unik,
        string $harga,
        string $tanggal_pembayaran,
        string $payment_id
    ) {
        $this->cek_kuota = $cek_kuota;
        $this->kode_unik = $kode_unik;
        $this->harga = $harga;
        $this->tanggal_pembayaran = $tanggal_pembayaran;
        $this->payment_id = $payment_id;
    }

    public function jsonSerialize(): array
    {
        return [
            'cek_kuota' => $this->cek_kuota,
            'kode_unik' => $this->kode_unik,
            'harga' => $this->harga,
            'tanggal_pembayaran' => $this->tanggal_pembayaran,
            'payment_id' => $this->payment_id
        ];
    }
}
