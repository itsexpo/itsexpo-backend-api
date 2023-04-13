<?php

namespace App\Core\Application\Service\GetUserWahanaSeni;

use JsonSerializable;

class GetUserWahana3DResponse implements JsonSerializable
{
    private string $id;
    private string $team_name;
    private string $team_code;
    private string $deskripsi_karya;
    private ?string $upload_karya_url;
    private ?string $deskripsi_url;
    private ?string $form_keaslian_url;

    private PembayaranObjResponse $pembayaran;
    private array $members;


    public function __construct(string $id, string $team_name, string $team_code, string $deskripsi_karya, ?string $upload_karya_url, ?string $deskripsi_url, ?string $form_keaslian_url, PembayaranObjResponse $pembayaran, array $members)
    {
        $this->id = $id;
        $this->team_name = $team_name;
        $this->team_code = $team_code;
        $this->deskripsi_karya = $deskripsi_karya;
        $this->upload_karya_url = $upload_karya_url;
        $this->deskripsi_url = $deskripsi_url;
        $this->form_keaslian_url = $form_keaslian_url;

        $this->pembayaran = $pembayaran;
        $this->members = $members;
    }
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'team_name' => $this->team_name,
            'team_code' => $this->team_code,
            'deskripsi_karya' => $this->deskripsi_karya,
            'status_pengumpulan' => ($this->upload_karya_url != null ? true : false),
            'upload_karya_url' => $this->upload_karya_url,
            'deskripsi_url' => $this->deskripsi_url,
            'form_keaslian_url' => $this->form_keaslian_url,
            'payment' => $this->pembayaran,
            'member' => $this->members
        ];
    }
}
