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
            UserException::throw("Bank Tidak Ditemukan", 1001, 404);
        }
        $kti_team_id = new KTITeamId($request->getKTITeamId());
        $kti_team = $this->kti_team_repository->find($kti_team_id);
        if (!$kti_team) {
            UserException::throw("KTI Team Tidak Ditemukan", 1001, 404);
        } elseif ($kti_team->getPembayaranId()->toString() != null) {
            UserException::throw("KTI Team Sudah Melakukan Pembayaran", 1001, 404);
        }

        $bukti_pembayaran_url = ImageUpload::create(
            $request->getBuktiPembayaran(),
            'pembayaran/kti',
            $account->getUserId()->toString(),
            "Bukti Pembayaran"
        )->upload();

        $pembayaran = Pembayaran::create(
            $request->getBankId(),
            11,
            4,
            $bukti_pembayaran_url,
            $request->getHarga()
        );

        $this->pembayaran_repository->persist($pembayaran);
        
        $this->kti_team_repository->updatePembayaran($kti_team_id, $pembayaran->getId());
    }
}
