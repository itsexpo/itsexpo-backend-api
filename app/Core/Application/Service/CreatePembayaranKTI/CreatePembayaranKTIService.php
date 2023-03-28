<?php

namespace App\Core\Application\Service\CreatePembayaranKTI;

use App\Exceptions\UserException;
use App\Core\Domain\Models\UserAccount;
use App\Core\Application\ImageUpload\ImageUpload;
use App\Core\Domain\Models\KTI\Team\KTITeamId;
use App\Core\Domain\Repository\PembayaranRepositoryInterface;
use App\Core\Domain\Repository\KTITeamRepositoryInterface;
use App\Core\Domain\Models\Pembayaran\Pembayaran;
use App\Core\Domain\Repository\ListBankRepositoryInterface;

class CreatePembayaranKTIService
{
    private KTITeamRepositoryInterface $kti_team_repository;
    private PembayaranRepositoryInterface $pembayaran_repository;
    private ListBankRepositoryInterface $list_bank_repository;

    /**
     * @param KTITeamRepositoryInterface $kti_team_repository
     * @param PembayaranRepositoryInterface $pembayaran_repository
     * @param ListBankRepositoryInterface $list_bank_repository
     */
    public function __construct(KTITeamRepositoryInterface $kti_team_repository, PembayaranRepositoryInterface $pembayaran_repository, ListBankRepositoryInterface $list_bank_repository)
    {
        $this->kti_team_repository = $kti_team_repository;
        $this->pembayaran_repository = $pembayaran_repository;
        $this->list_bank_repository = $list_bank_repository;
    }

    public function execute(CreatePembayaranKTIRequest $request, UserAccount $account)
    {
        $bank = $this->list_bank_repository->find($request->getBankId());
        if (!$bank) {
            UserException::throw("Bank Tidak Ditemukan", 1003, 404);
        }
        $kti_team_id = new KTITeamId($request->getKTITeamId());
        $kti_team = $this->kti_team_repository->find($kti_team_id);
        if (!$kti_team) {
            UserException::throw("KTI Team Tidak Ditemukan", 1003, 404);
        }

        $pembayaran = $this->pembayaran_repository->find($kti_team->getPembayaranId());
        
        if (!$pembayaran) {
            UserException::throw("Data pembayaran tidak dapat ditemukan", 1003, 404);
        }

        if ($pembayaran->getStatusPembayaranId() != 5) {
            UserException::throw("Status pembayaran tidak sesuai", 1003, 404);
        }

        $bukti_pembayaran_url = ImageUpload::create(
            $request->getBuktiPembayaran(),
            'pembayaran/kti',
            $account->getUserId()->toString(),
            "Bukti Pembayaran"
        )->upload();

        $newPembayaran = Pembayaran::update(
            $pembayaran->getId(),
        $newPembayaran = Pembayaran::update(
            $pembayaran->getId(),
            $request->getBankId(),
            12,
            4,
            $request->getAtasNama(),
            $request->getAtasNama(),
            $bukti_pembayaran_url,
            $request->getAtasNama(),
            $request->getHarga(),
            $pembayaran->getDeadline()
        );

        $this->pembayaran_repository->persist($newPembayaran);
        $this->pembayaran_repository->persist($newPembayaran);
        
        $this->kti_team_repository->updatePembayaran($kti_team_id, $newPembayaran->getId());
        $this->kti_team_repository->updatePembayaran($kti_team_id, $newPembayaran->getId());
    }
}
