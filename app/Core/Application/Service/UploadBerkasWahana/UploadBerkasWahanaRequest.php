<?php

namespace App\Core\Application\Service\UploadBerkasWahana;

use Illuminate\Http\UploadedFile;

class UploadBerkasWahanaRequest
{
    private UploadedFile $upload_karya;
    private UploadedFile $deskripsi;
    private UploadedFile $form_keaslian;

    public function __construct(UploadedFile $upload_karya, UploadedFile $deskripsi, UploadedFile $form_keaslian)
    {
        $this->upload_karya = $upload_karya;
        $this->deskripsi = $deskripsi;
        $this->form_keaslian = $form_keaslian;
    }

    public function getUploadKarya(): UploadedFile
    {
        return $this->upload_karya;
    }

    public function getDeskripsi(): UploadedFile
    {
        return $this->deskripsi;
    }

    public function getFormKeaslian(): UploadedFile
    {
        return $this->form_keaslian;
    }
}
