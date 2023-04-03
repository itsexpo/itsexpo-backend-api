<?php

namespace App\Core\Application\Service\GetJurnalistikAdminDetail;

use App\Core\Domain\Repository\PembayaranRepositoryInterface;
use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikTeamId;
use App\Core\Domain\Repository\JurnalistikTeamRepositoryInterface;
use App\Core\Domain\Repository\StatusPembayaranRepositoryInterface;
use App\Core\Domain\Repository\JurnalistikMemberRepositoryInterface;
use App\Core\Domain\Repository\ListBankRepositoryInterface;

class GetJurnalistikAdminDetailService
{
    private JurnalistikTeamRepositoryInterface $jurnalistik_team_repository;
    private JurnalistikMemberRepositoryInterface $jurnalistik_member_repository;
    private StatusPembayaranRepositoryInterface $status_pembayaran_repository;
    private PembayaranRepositoryInterface $pembayaran_repository;
    private ListBankRepositoryInterface $list_bank_repository;

    public function __construct(JurnalistikTeamRepositoryInterface $jurnalistik_team_repository, JurnalistikMemberRepositoryInterface $jurnalistik_member_repository, StatusPembayaranRepositoryInterface $status_pembayaran_repository, PembayaranRepositoryInterface $pembayaran_repository, ListBankRepositoryInterface $list_bank_repository)
    {
        $this->jurnalistik_team_repository = $jurnalistik_team_repository;
        $this->jurnalistik_member_repository = $jurnalistik_member_repository;
        $this->status_pembayaran_repository = $status_pembayaran_repository;
        $this->pembayaran_repository = $pembayaran_repository;
        $this->list_bank_repository = $list_bank_repository;
    }

    public function execute(string $team_id): GetJurnalistikAdminDetailResponse
    {
        $id = new JurnalistikTeamId($team_id);
        $team = $this->jurnalistik_team_repository->find($id);
        $members = $this->jurnalistik_member_repository->findAllMember($id);

        $member_array = [];
        foreach ($members as $member) {
            $kab = $member->getKabupatenId();
            $prov = $member->getProvinsiId();
            $nama = $member->getName();
            $ketua = $member->getMemberType()->value;
            $id_line = $member->getIdLine();
            $id_card_url = $member->getIdCardUrl();
            $follow_sosmed_url = $member->getFollowSosmedUrl();
            $share_poster_url = $member->getSharePosterUrl();

            $memb = new GetJurnalistikAdminDetailTeamMemberResponse($nama, $ketua, $prov, $id_line, $kab, $id_card_url, $follow_sosmed_url, $share_poster_url);
            array_push($member_array, $memb);
        }

        $payment_id = $team->getPembayaranId();

        if ($payment_id->toString() == null) {
            $payment_status = "AWAITING PAYMENT";

            $payment_obj = new PembayaranObjResponse($payment_status);

            $final = new GetJurnalistikAdminDetailResponse($team->getTeamName(), $team->getTeamCode(), $payment_obj, $member_array);
            return $final;
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

            $final = new GetJurnalistikAdminDetailResponse($team->getTeamName(), $team->getTeamCode(), $payment_obj, $member_array);
            return $final;
        }
    }
}
