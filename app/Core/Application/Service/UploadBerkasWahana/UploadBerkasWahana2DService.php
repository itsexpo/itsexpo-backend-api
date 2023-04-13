<?php

namespace App\Core\Application\Service\UploadBerkasWahana;

use App\Exceptions\UserException;
use App\Core\Domain\Models\UserAccount;
use App\Core\Domain\Models\Wahana2D\Wahana2D;
use App\Core\Application\ImageUpload\ImageUpload;
use App\Core\Domain\Repository\Wahana2DRepositoryInterface;

class UploadBerkasWahana2DService
{
    private Wahana2DRepositoryInterface $wahana_2d_repository;

    /**
     * @param Wahana2DRepositoryInterface $wahana_2d_repository
     */
    public function __construct(Wahana2DRepositoryInterface $wahana_2d_repository)
    {
        $this->wahana_2d_repository = $wahana_2d_repository;
    }

    public function execute(UploadBerkasWahanaRequest $request, UserAccount $account)
    {
        $wahana2d = $this->wahana_2d_repository->findByUserId($account->getUserId());
        if (!$wahana2d) {
            UserException::throw("Anda Belum Terdaftar Sebagai Peserta Wahana Seni 2D", 6002);
        }
        if ($wahana2d->getUploadKaryaUrl()) {
            UserException::throw("Anda Sudah Mengupload File Berkas Wahana Seni 2D", 6002);
        }

        $uploadKaryaUrl = ImageUpload::create(
            $request->getUploadKarya(),
            'wahana_2d/upload_karya',
            $account->getUserId()->toString(),
            'Upload Karya',
            true
        )->upload();

        $deskripsiUrl = ImageUpload::create(
            $request->getDeskripsi(),
            'wahana_2d/deskripsi',
            $account->getUserId()->toString(),
            'Deskripsi',
        )->upload();

        $formKeaslian = ImageUpload::create(
            $request->getFormKeaslian(),
            'wahana_2d/form_keaslian',
            $account->getUserId()->toString(),
            'Form Keaslian',
        )->upload();

        $newWahana2D = Wahana2D::update(
            $wahana2d->getId(),
            $wahana2d->getUserId(),
            $wahana2d->getPembayaranId(),
            $wahana2d->getDepartemenId(),
            $wahana2d->getName(),
            $wahana2d->getNrp(),
            $wahana2d->getKontak(),
            $wahana2d->getStatus(),
            $wahana2d->getKTM(),
            $uploadKaryaUrl,
            $deskripsiUrl,
            $formKeaslian,
        );

        $this->wahana_2d_repository->persist($newWahana2D);
    }
}
