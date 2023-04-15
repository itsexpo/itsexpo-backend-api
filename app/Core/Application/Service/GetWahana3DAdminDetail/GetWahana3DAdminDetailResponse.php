<?php

namespace App\Core\Application\Service\GetWahana3DAdminDetail;

use JsonSerializable;

class GetWahana3DAdminDetailResponse implements JsonSerializable
{
    private string $team_name;
    private string $team_code;
    private string $deskripsi_karya;
    private string $deskripsi_karya_url;
    private string $upload_karya_url;
    private string $form_keaslian_url;
    private PembayaranObjResponse $payment;
    private array $team_members;

    public function __construct(
        string $team_name,
        string $team_code,
        PembayaranObjResponse $payment,
        string $deskripsi_karya,
        ?string $deskripsi_karya_url,
        ?string $upload_karya_url,
        ?string $form_keaslian_url,
        array $team_members
    ) {
        $this->team_name = $team_name;
        $this->team_code = $team_code;
        $this->deskripsi_karya = $deskripsi_karya;
        $this->deskripsi_karya_url = $deskripsi_karya_url;
        $this->upload_karya_url = $upload_karya_url;
        $this->form_keaslian_url = $form_keaslian_url;
        $this->payment = $payment;
        $this->team_members = $team_members;
    }

    public function jsonSerialize(): array
    {
        return [
          'team_name' => $this->team_name,
          'team_code' => $this->team_code,
          'deskripsi_karya' => $this->deskripsi_karya,
          'deskripsi_karya_url' => $this->deskripsi_karya_url,
          'upload_karya_url' => $this->upload_karya_url,
          'form_keaslian_url' => $this->form_keaslian_url,
          'payment' => $this->payment,
          'team_member' => $this->team_members
        ];
    }
}
