<?php

namespace App\Core\Application\Service\CekPembayaranKti;

use JsonSerializable;

class CekPembayaranKtiResponse implements JsonSerializable
{
    private bool $cek_kuota;
    private string $kode_unik;
    private string $harga;
    private string $tanggal_pembayaran;

    public function __construct(
        bool $cek_kuota,
        string $kode_unik,
        string $harga,
        string $tanggal_pembayaran
    ) {
        $this->cek_kuota = $cek_kuota;
        $this->kode_unik = $kode_unik;
        $this->harga = $harga;
        $this->tanggal_pembayaran = $tanggal_pembayaran;
    }

    public function jsonSerialize(): array
    {
        return [
            'cek_kuota' => $this->cek_kuota,
            'kode_unik' => $this->kode_unik,
            'harga' => $this->harga,
            'tanggal_pembayaran' => $this->tanggal_pembayaran,
        ];
    }
}
