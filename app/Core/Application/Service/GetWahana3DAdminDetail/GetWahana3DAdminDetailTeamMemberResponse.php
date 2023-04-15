<?php

namespace App\Core\Application\Service\GetWahana3DAdminDetail;

use JsonSerializable;

class GetWahana3DAdminDetailTeamMemberResponse implements JsonSerializable
{
    private string $nama;
    private bool $ketua;
    private string $nrp;
    private string $kontak;
    private int $departemen_id;
    private string $ktm_url;
  
    public function __construct(string $nama, bool $ketua, string $nrp, string $kontak, int $departemen_id, string $ktm_url)
    {
        $this->nama = $nama;
        $this->ketua = $ketua;
        $this->nrp = $nrp;
        $this->kontak = $kontak;
        $this->departemen_id = $departemen_id;
        $this->ktm_url = $ktm_url;
    }

    public function jsonSerialize(): array
    {
        return [
          'name' => $this->nama,
          'ketua' => $this->ketua,
          'departemen_id' => $this->departemen_id,
          'nrp' => $this->nrp,
          'kontak' => $this->kontak,
          'bukti_upload_ktm' => $this->ktm_url
        ];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->nama;
    }

    /**
     * @return bool
     */
    public function getKetua(): bool
    {
        return $this->ketua;
    }

    /**
     * @return string
     */
    public function getKtmUrl(): string
    {
        return $this->ktm_url;
    }
}
