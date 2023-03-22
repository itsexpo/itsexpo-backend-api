<?php

namespace App\Core\Application\Service\CreatePembayaranJurnalistik;

use App\Exceptions\UserException;
use App\Core\Domain\Models\UserAccount;
use App\Core\Application\ImageUpload\ImageUpload;
use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikTeamId;
use App\Core\Domain\Repository\PembayaranRepositoryInterface;
use App\Core\Domain\Repository\JurnalistikTeamRepositoryInterface;
use App\Core\Domain\Models\Pembayaran\Pembayaran;
use App\Core\Domain\Repository\ListBankRepositoryInterface;

class CreatePembayaranJurnalistikService
{
    private JurnalistikTeamRepositoryInterface $jurnalistik_team_repository;
    private PembayaranRepositoryInterface $pembayaran_repository;
    private ListBankRepositoryInterface $list_bank_repository;

    /**
     * @param JurnalistikTeamRepositoryInterface $jurnalistik_team_repository
     * @param PembayaranRepositoryInterface $pembayaran_repository
     * @param ListBankRepositoryInterface $list_bank_repository
     */
    public function __construct(JurnalistikTeamRepositoryInterface $jurnalistik_team_repository, PembayaranRepositoryInterface $pembayaran_repository, ListBankRepositoryInterface $list_bank_repository)
    {
        $this->jurnalistik_team_repository = $jurnalistik_team_repository;
        $this->pembayaran_repository = $pembayaran_repository;
        $this->list_bank_repository = $list_bank_repository;
    }

    public function execute(CreatePembayaranJurnalistikRequest $request, UserAccount $account)
    {
        $bank = $this->list_bank_repository->find($request->getBankId());
        if (!$bank) {
            UserException::throw("Bank Tidak Ditemukan", 1001, 404);
        }
        $jurnalistik_team_id = new JurnalistikTeamId($request->getJurnalistikTeamId());
        $jurnalistik_team = $this->jurnalistik_team_repository->find($jurnalistik_team_id);
        if (!$jurnalistik_team) {
            UserException::throw("Jurnalistik Team Tidak Ditemukan", 1001, 404);
        }
        $pembayaran = $this->pembayaran_repository->find($jurnalistik_team->getPembayaranId());
        $pembayaran_id = false;
        if ($pembayaran != null) {
            if ($pembayaran->getStatusPembayaranId() != 1) {
                UserException::throw("Jurnalistik Team Sudah Melakukan Pembayaran", 1001, 404);
            }
            $pembayaran_id = true;
        }
        $bukti_pembayaran_url = ImageUpload::create(
            $request->getBuktiPembayaran(),
            'pembayaran/jurnalistik',
            $account->getUserId()->toString(),
            "Bukti Pembayaran"
        )->upload();
        if ($pembayaran_id) {
            $pembayaran = Pembayaran::update(
                $pembayaran->getId(),
                $request->getBankId(),
                11,
                4,
                $request->getAtasNama(),
                $bukti_pembayaran_url,
                $request->getHarga()
            );
        } else {
            $pembayaran = Pembayaran::create(
                $request->getBankId(),
                11,
                4,
                $request->getAtasNama(),
                $bukti_pembayaran_url,
                $request->getHarga()
            );
        }
        

        $this->pembayaran_repository->persist($pembayaran);
        
        $this->jurnalistik_team_repository->updatePembayaran($jurnalistik_team_id, $pembayaran->getId());
    }
}
