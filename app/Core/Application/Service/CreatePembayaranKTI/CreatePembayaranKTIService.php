<?php

namespace App\Core\Application\Service\CreatePembayaranKTI;

use App\Exceptions\UserException;
use Illuminate\Support\Facades\Mail;
use App\Core\Domain\Models\UserAccount;
use App\Core\Application\Mail\PaymentWaiting;
use App\Core\Domain\Models\KTI\Team\KTITeamId;
use App\Core\Application\ImageUpload\ImageUpload;
use App\Core\Domain\Models\Pembayaran\Pembayaran;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Domain\Repository\KTITeamRepositoryInterface;
use App\Core\Domain\Repository\ListBankRepositoryInterface;
use App\Core\Domain\Repository\KTIMemberRepositoryInterface;
use App\Core\Domain\Repository\PembayaranRepositoryInterface;

class CreatePembayaranKTIService
{
    private KTITeamRepositoryInterface $kti_team_repository;
    private KTIMemberRepositoryInterface $kti_member_repository;
    private UserRepositoryInterface $user_repository;
    private PembayaranRepositoryInterface $pembayaran_repository;
    private ListBankRepositoryInterface $list_bank_repository;

    /**
     * @param KTITeamRepositoryInterface $kti_team_repository
     * @param KTIMemberRepositoryInterface $kti_member_repository
     * @param UserRepositoryInterface $user_repository
     * @param PembayaranRepositoryInterface $pembayaran_repository
     * @param ListBankRepositoryInterface $list_bank_repository
     */
    public function __construct(KTITeamRepositoryInterface $kti_team_repository, KTIMemberRepositoryInterface $kti_member_repository, UserRepositoryInterface $user_repository, PembayaranRepositoryInterface $pembayaran_repository, ListBankRepositoryInterface $list_bank_repository)
    {
        $this->kti_team_repository = $kti_team_repository;
        $this->kti_member_repository = $kti_member_repository;
        $this->user_repository = $user_repository;
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
        $ketua_user = $this->user_repository->find($kti_team->getUserId());
        if (!$kti_team) {
            UserException::throw("Ketua Team User Tidak Ditemukan", 1003, 404);
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
            $request->getBankId(),
            12,
            4,
            $request->getAtasNama(),
            $bukti_pembayaran_url,
            $request->getHarga(),
            $pembayaran->getDeadline()
        );

        $this->pembayaran_repository->persist($newPembayaran);
        $this->kti_team_repository->updatePembayaran($kti_team_id, $newPembayaran->getId());

        Mail::to($ketua_user->getEmail()->toString())->send(new PaymentWaiting(
            $ketua_user->getName(),
        ));
    }
}
