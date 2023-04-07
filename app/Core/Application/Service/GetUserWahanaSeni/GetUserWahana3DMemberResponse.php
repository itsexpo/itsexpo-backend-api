<?php

namespace App\Core\Application\Service\GetUserWahanaSeni;

use JsonSerializable;

class GetUserWahana3DMemberResponse implements JsonSerializable
{
    private string $nama;
    private string $kontak;
    private string $nrp;
    private string $departemen;
    private string $ktm_url;
    private bool $ketua;

    public function __construct(string $nama, string $nrp, string $departemen, string $kontak, string $ktm_url, bool $ketua)
    {
        $this->nama = $nama;
        $this->kontak = $kontak;
        $this->nrp = $nrp;
        $this->departemen = $departemen;
        $this->ktm_url = $ktm_url;
        $this->ketua = $ketua;
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->nama,
            'ketua' => $this->ketua,
            'nrp' => $this->nrp,
            'departemen' => $this->departemen,
            'kontak' => $this->kontak,
            'ktm_url' => $this->ktm_url
        ];
    }
}
