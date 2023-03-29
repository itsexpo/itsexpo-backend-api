<?php

namespace App\Core\Application\Service\CreatePembayaranJurnalistik;

use App\Exceptions\UserException;
use Illuminate\Support\Facades\Mail;
use App\Core\Domain\Models\UserAccount;
use App\Core\Application\ImageUpload\ImageUpload;
use App\Core\Application\Mail\PaymentWaiting;
use App\Core\Domain\Models\Pembayaran\Pembayaran;
use App\Core\Domain\Repository\ListBankRepositoryInterface;
use App\Core\Domain\Repository\PembayaranRepositoryInterface;
use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikTeamId;
use App\Core\Domain\Repository\JurnalistikTeamRepositoryInterface;
use App\Core\Domain\Repository\JurnalistikMemberRepositoryInterface;
use App\Core\Domain\Repository\UserRepositoryInterface;

class CreatePembayaranJurnalistikService
{
    private JurnalistikTeamRepositoryInterface $jurnalistik_team_repository;
    private JurnalistikMemberRepositoryInterface $jurnalistik_member_repository;
    private PembayaranRepositoryInterface $pembayaran_repository;
    private ListBankRepositoryInterface $list_bank_repository;
    private UserRepositoryInterface $user_repository;

    /**
     * @param JurnalistikTeamRepositoryInterface $jurnalistik_team_repository
     * @param JurnalistikMemberRepositoryInterface $jurnalistik_member_repository
     * @param PembayaranRepositoryInterface $pembayaran_repository
     * @param ListBankRepositoryInterface $list_bank_repository
     * @param UserRepositoryInterface $user_repository
     */
    public function __construct(JurnalistikTeamRepositoryInterface $jurnalistik_team_repository, JurnalistikMemberRepositoryInterface $jurnalistik_member_repository, PembayaranRepositoryInterface $pembayaran_repository, ListBankRepositoryInterface $list_bank_repository, UserRepositoryInterface $user_repository)
    {
        $this->jurnalistik_team_repository = $jurnalistik_team_repository;
        $this->jurnalistik_member_repository = $jurnalistik_member_repository;
        $this->pembayaran_repository = $pembayaran_repository;
        $this->list_bank_repository = $list_bank_repository;
        $this->user_repository = $user_repository;
    }

    public function execute(CreatePembayaranJurnalistikRequest $request, UserAccount $account)
    {
        $bank = $this->list_bank_repository->find($request->getBankId());
        if (!$bank) {
            UserException::throw("Bank Tidak Ditemukan", 1002, 404);
        }
        $jurnalistik_team_id = new JurnalistikTeamId($request->getJurnalistikTeamId());
        $jurnalistik_team = $this->jurnalistik_team_repository->find($jurnalistik_team_id);
        if (!$jurnalistik_team) {
            UserException::throw("Jurnalistik Team Tidak Ditemukan", 1002, 404);
        }
        $ketua_member = $this->jurnalistik_member_repository->findKetua($jurnalistik_team_id);
        if (!$ketua_member) {
            UserException::throw("Ketua Team Tidak Ditemukan", 1002, 404);
        }
        $ketua_user = $this->user_repository->find($ketua_member->getUserId());
        if (!$ketua_user) {
            UserException::throw("Ketua Team User Tidak Ditemukan", 1002, 404);
        }
        $pembayaran = $this->pembayaran_repository->find($jurnalistik_team->getPembayaranId());

        if (!$pembayaran) {
            UserException::throw("Data pembayaran tidak dapat ditemukan", 1002, 404);
        }

        if ($pembayaran->getStatusPembayaranId() != 5) {
            UserException::throw("Status pembayaran tidak sesuai", 1002, 404);
        }

        $bukti_pembayaran_url = ImageUpload::create(
            $request->getBuktiPembayaran(),
            'pembayaran/jurnalistik',
            $account->getUserId()->toString(),
            "Bukti Pembayaran"
        )->upload();

        $newPembayaran = Pembayaran::update(
            $pembayaran->getId(),
            $request->getBankId(),
            11,
            4,
            $request->getAtasNama(),
            $bukti_pembayaran_url,
            $request->getHarga(),
            $pembayaran->getDeadline()
        );

        $this->pembayaran_repository->persist($newPembayaran);
        $this->jurnalistik_team_repository->updatePembayaran($jurnalistik_team_id, $newPembayaran->getId());

        Mail::to($ketua_user->getEmail()->toString())->send(new PaymentWaiting(
            $ketua_user->getName(),
        ));
    }
}
