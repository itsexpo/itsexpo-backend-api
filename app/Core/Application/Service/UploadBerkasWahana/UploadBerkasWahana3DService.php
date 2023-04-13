<?php

namespace App\Core\Application\Service\UploadBerkasWahana;

use App\Exceptions\UserException;
use App\Core\Domain\Models\UserAccount;
use App\Core\Application\ImageUpload\ImageUpload;
use App\Core\Domain\Models\Wahana3D\Team\Wahana3DTeam;
use App\Core\Domain\Repository\Wahana3DTeamRepositoryInterface;

class UploadBerkasWahana3DService
{
    private Wahana3DTeamRepositoryInterface $wahana_3d_team_repository;

    /**
     * @param Wahana3DTeamRepositoryInterface $wahana_3d_team_repository
     */
    public function __construct(Wahana3DTeamRepositoryInterface $wahana_3d_team_repository)
    {
        $this->wahana_3d_team_repository = $wahana_3d_team_repository;
    }

    public function execute(UploadBerkasWahanaRequest $request, UserAccount $account)
    {
        $wahana3d = $this->wahana_3d_team_repository->findByUserId($account->getUserId());
        if (!$wahana3d) {
            UserException::throw("Anda Belum Terdaftar Sebagai Peserta Wahana Seni 3D", 6002);
        }
        if ($wahana3d->getUploadKaryaUrl()) {
            UserException::throw("Anda Sudah Mengupload File Berkas Wahana Seni 3D", 6002);
        }

        $uploadKaryaUrl = ImageUpload::create(
            $request->getUploadKarya(),
            'wahana_3d/upload_karya',
            $account->getUserId()->toString(),
            'Upload Karya',
            true
        )->upload();

        $deskripsiUrl = ImageUpload::create(
            $request->getDeskripsi(),
            'wahana_3d/deskripsi',
            $account->getUserId()->toString(),
            'Deskripsi',
        )->upload();

        $formKeaslian = ImageUpload::create(
            $request->getFormKeaslian(),
            'wahana_3d/form_keaslian',
            $account->getUserId()->toString(),
            'Form Keaslian',
        )->upload();

        $newWahana3D = Wahana3DTeam::update(
            $wahana3d->getId(),
            $wahana3d->getPembayaranId(),
            $wahana3d->getUserId(),
            $wahana3d->getTeamName(),
            $wahana3d->getTeamCode(),
            $wahana3d->getDeskripsiKarya(),
            $uploadKaryaUrl,
            $deskripsiUrl,
            $formKeaslian,
        );

        $this->wahana_3d_team_repository->persist($newWahana3D);
    }
}
