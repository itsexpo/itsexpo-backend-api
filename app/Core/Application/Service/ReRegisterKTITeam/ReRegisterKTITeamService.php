<?php

namespace App\Core\Application\Service\ReRegisterKTITeam;

use App\Core\Application\ImageUpload\ImageUpload;
use App\Core\Domain\Models\KTI\Team\KTITeam;
use App\Core\Domain\Models\Pembayaran\Pembayaran;
use App\Core\Domain\Models\UserAccount;
use App\Core\Domain\Repository\KTITeamRepositoryInterface;
use App\Core\Domain\Repository\PembayaranRepositoryInterface;
use App\Exceptions\UserException;
use Carbon\Carbon;

class ReRegisterKTITeamService
{
    private KTITeamRepositoryInterface $kti_team_repository;
    private PembayaranRepositoryInterface $pembayaran_repository;

    public function __construct(KTITeamRepositoryInterface $kti_team_repository, PembayaranRepositoryInterface $pembayaran_repository)
    {
        $this->kti_team_repository = $kti_team_repository;
        $this->pembayaran_repository = $pembayaran_repository;
    }

    public function execute(ReRegisterKTITeamRequest $request, UserAccount $account)
    {
        $reregistered_user = $this->kti_team_repository->find($request->getKTITeamId());

        if (!$reregistered_user->isLolosPaper()) {
            UserException::throw("Team tidak lolos ke tahap Full Paper", 1005, 401);
        }

        if ($reregistered_user->getFullPaper() !== "") {
            UserException::throw("Team sudah mengirimkan Full Paper", 1006, 400);
        }

        $paperUrl = ImageUpload::create(
            $request->getFilePaper(),
            'kti/file_paper',
            $account->getUserId()->toString(),
            'File Full Paper'
        )->upload();

        $due_payment = Carbon::now()->addDay();

        $pembayaran = Pembayaran::create(
            null,
            12,
            5,
            null,
            null,
            130000,
            $due_payment
        );

        $this->pembayaran_repository->persist($pembayaran);

        $reregistered_user->reregister(
            $pembayaran->getId(),
            $paperUrl
        );

        $this->kti_team_repository->persist($reregistered_user);
    }
}
