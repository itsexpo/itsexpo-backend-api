<?php

namespace App\Core\Application\Service\CreatePembayaranRobotInAction;

use App\Exceptions\UserException;
use App\Core\Domain\Models\UserAccount;
use App\Core\Application\ImageUpload\ImageUpload;
use App\Core\Domain\Repository\PembayaranRepositoryInterface;
use App\Core\Domain\Models\Pembayaran\Pembayaran;
use App\Core\Domain\Models\RobotInAction\Team\RobotInActionTeamId;
use App\Core\Domain\Repository\ListBankRepositoryInterface;
use App\Core\Domain\Repository\RobotInActionTeamRepositoryInterface;

class CreatePembayaranRobotInActionService
{
    private RobotInActionTeamRepositoryInterface $robotInAction_team_repository;
    private PembayaranRepositoryInterface $pembayaran_repository;
    private ListBankRepositoryInterface $list_bank_repository;

    /**
     * @param RobotInActionTeamRepositoryInterface $RobotInActionTeamRepositoryInterface
     * @param PembayaranRepositoryInterface $pembayaran_repository
     * @param ListBankRepositoryInterface $list_bank_repository
     */
    public function __construct(RobotInActionTeamRepositoryInterface $robotInAction_team_repository, PembayaranRepositoryInterface $pembayaran_repository, ListBankRepositoryInterface $list_bank_repository)
    {
        $this->robotInAction_team_repository = $robotInAction_team_repository;
        $this->pembayaran_repository = $pembayaran_repository;
        $this->list_bank_repository = $list_bank_repository;
    }

    public function execute(CreatePembayaranRobotInActionRequest $request, UserAccount $account)
    {
        $bank = $this->list_bank_repository->find($request->getBankId());
        if (!$bank) {
            UserException::throw("Bank Tidak Ditemukan", 1001, 404);
        }
        $robotInAction_team_id = new RobotInActionTeamId($request->getRobotInActionTeamId());
        $robotInAction_team = $this->robotInAction_team_repository->find($robotInAction_team_id);
        if (!$robotInAction_team) {
            UserException::throw("Robot In Action Team Tidak Ditemukan", 1001, 404);
        }
        $pembayaran = $this->pembayaran_repository->find($robotInAction_team->getPembayaranId());
        
        if (!$pembayaran) {
            UserException::throw("Data pembayaran tidak dapat ditemukan", 1001, 404);
        }

        if ($pembayaran->getStatusPembayaranId() != 5) {
            UserException::throw("Status pembayaran tidak sesuai", 1001, 404);
        }

        $bukti_pembayaran_url = ImageUpload::create(
            $request->getBuktiPembayaran(),
            'pembayaran/robotInAction',
            $account->getUserId()->toString(),
            "Bukti Pembayaran"
        )->upload();

        $newPembayaran = Pembayaran::update(
            $pembayaran->getId(),
            $request->getBankId(),
            13,
            4,
            $request->getAtasNama(),
            $bukti_pembayaran_url,
            $request->getHarga(),
            $pembayaran->getDeadline()
        );

        $this->pembayaran_repository->persist($newPembayaran);
        
        $this->robotInAction_team_repository->updatePembayaran($robotInAction_team_id, $newPembayaran->getId());
    }
}
