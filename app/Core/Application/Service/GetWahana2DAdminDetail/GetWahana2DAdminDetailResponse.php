<?php

namespace App\Core\Application\Service\GetWahana2DAdminDetail;

use JsonSerializable;

class GetWahana2DAdminDetailResponse implements JsonSerializable
{
    private string $name;
    private string $bukti_upload_ktm;
    private string $upload_karya_url;
    private string $department;
    private string $nrp;
    private string $deskripsi_url;
    private string $form_keaslian_url;
    private string $kontak;
    private string $status;
    private PembayaranObjResponse $payment;
    public function __construct(
        string $name,
        string $bukti_upload_ktm,
        string $department,
        string $upload_karya_url,
        string $nrp,
        string $deskripsi_url,
        string $form_keaslian_url,
        string $kontak,
        string $status,
        PembayaranObjResponse $payment
    ) {
        $this->name = $name;
        $this->bukti_upload_ktm = $bukti_upload_ktm;
        $this->upload_karya_url = $upload_karya_url;
        $this->payment = $payment;
        $this->department = $department;
        $this->nrp = $nrp;
        $this->deskripsi_url = $deskripsi_url;
        $this->form_keaslian_url = $form_keaslian_url;
        $this->kontak = $kontak;
        $this->status = $status;
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'department' => $this->department,
            'bukti_upload_ktm' => $this->bukti_upload_ktm,
            'nrp' => $this->nrp,
            'upload_karya_url' => $this->upload_karya_url,
            'deskripsi_url' => $this->deskripsi_url,
            'form_keaslian_url' => $this->form_keaslian_url,
            'kontak' => $this->kontak,
            'status' => $this->status,
            'payment' => $this->payment,
        ];
    }
}
