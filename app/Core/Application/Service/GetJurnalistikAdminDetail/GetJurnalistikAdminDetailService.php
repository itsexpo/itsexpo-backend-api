<?php

namespace App\Core\Application\Service\GetJurnalistikAdminDetail;

use App\Core\Domain\Repository\PembayaranRepositoryInterface;
use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikTeamId;
use App\Core\Domain\Repository\JurnalistikTeamRepositoryInterface;
use App\Core\Domain\Repository\StatusPembayaranRepositoryInterface;
use App\Core\Domain\Repository\JurnalistikMemberRepositoryInterface;

class GetJurnalistikAdminDetailService
{
    private JurnalistikTeamRepositoryInterface $jurnalistik_team_repository;
    private JurnalistikMemberRepositoryInterface $jurnalistik_member_repository;
    private StatusPembayaranRepositoryInterface $status_pembayaran_repository;
    private PembayaranRepositoryInterface $pembayaran_repository;

    public function __construct(JurnalistikTeamRepositoryInterface $jurnalistik_team_repository, JurnalistikMemberRepositoryInterface $jurnalistik_member_repository, StatusPembayaranRepositoryInterface $status_pembayaran_repository, PembayaranRepositoryInterface $pembayaran_repository)
    {
        $this->jurnalistik_team_repository = $jurnalistik_team_repository;
        $this->jurnalistik_member_repository = $jurnalistik_member_repository;
        $this->status_pembayaran_repository = $status_pembayaran_repository;
        $this->pembayaran_repository = $pembayaran_repository;
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
        $payment = $this->pembayaran_repository->find($payment_id);
        $payment_status = $this->status_pembayaran_repository->find($payment->getStatusPembayaranId())->getStatus();
        $payment_image_url = $payment->getBuktiPembayaranUrl();

        $payment_obj = new PembayaranObjResponse($payment_status, $payment_image_url);

        $final = new GetJurnalistikAdminDetailResponse($team->getTeamName(), $team->getTeamCode(), $payment_obj, $member_array);
        return $final;
    }
}
