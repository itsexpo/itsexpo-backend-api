<?php

namespace App\Core\Application\Service\GetKtiAdminDetail;

use App\Exceptions\UserException;
use App\Core\Domain\Models\KTI\Team\KTITeamId;
use App\Core\Domain\Repository\KTITeamRepositoryInterface;
use App\Core\Domain\Repository\KTIMemberRepositoryInterface;
use App\Core\Domain\Repository\PembayaranRepositoryInterface;
use App\Core\Domain\Repository\StatusPembayaranRepositoryInterface;
use App\Core\Domain\Repository\ListBankRepositoryInterface;

class GetKtiAdminDetailService
{
    private KTITeamRepositoryInterface $kti_team_repository;
    private KTIMemberRepositoryInterface $kti_member_repository;
    private StatusPembayaranRepositoryInterface $status_pembayaran_repository;
    private PembayaranRepositoryInterface $pembayaran_repository;
    private ListBankRepositoryInterface $list_bank_repository;


    public function __construct(KTITeamRepositoryInterface $kti_team_repository, KTIMemberRepositoryInterface $kti_member_repository, StatusPembayaranRepositoryInterface $status_pembayaran_repository, PembayaranRepositoryInterface $pembayaran_repository, ListBankRepositoryInterface $list_bank_repository)
    {
        $this->kti_team_repository = $kti_team_repository;
        $this->kti_member_repository = $kti_member_repository;
        $this->status_pembayaran_repository = $status_pembayaran_repository;
        $this->pembayaran_repository = $pembayaran_repository;
        $this->list_bank_repository = $list_bank_repository;
    }

    public function execute(string $team_id): GetKtiAdminDetailResponse
    {
        $id = new KTITeamId($team_id);
        $team = $this->kti_team_repository->find($id);
        if (!$team) {
            UserException::throw("KTI Team tidak ditemukan!", 3005, 404);
        }
        $members = $this->kti_member_repository->findAllMember($id);

        $member_array = [];
        foreach ($members as $member) {
            $nama = $member->getName();
            $ketua = $member->getMemberType()->value;
            $no_telp = $member->getNoTelp();

            $memb = new GetKtiAdminDetailTeamMemberResponse($nama, $ketua, $no_telp);
            array_push($member_array, $memb);
        }

        $payment_id = $team->getPembayaranId();

        if ($payment_id->toString() == null) {
            $payment_status = "AWAITING PAYMENT";

            $payment_obj = new PembayaranObjResponse($payment_status);
        } else {
            $payment = $this->pembayaran_repository->find($payment_id);
            $payment_status = $this->status_pembayaran_repository->find($payment->getStatusPembayaranId())->getStatus();
            $payment_image_url = $payment->getBuktiPembayaranUrl();
            $payment_atas_nama = $payment->getAtasNama();
            if ($payment->getStatusPembayaranId() == 5) {
                $payment_bank = null;
            } else {
                $payment_bank = $this->list_bank_repository->find($payment->getListBankId())->getName();
            }
            $payment_harga = $payment->getHarga();

            $payment_obj = new PembayaranObjResponse($payment_status, $payment_id->toString(), $payment_image_url, $payment_atas_nama, $payment_bank, $payment_harga);
        }

        $final = new GetKtiAdminDetailResponse(
            $team->getTeamName(),
            $team->getTeamCode(),
            $team->getAsalInstansi(),
            $team->getFollowSosmed(),
            $team->getBuktiRepost(),
            $team->getTwibbon(),
            $team->getAbstrak(),
            $payment_obj,
            $member_array
        );
        return $final;
    }
}
