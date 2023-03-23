<?php

namespace App\Core\Application\Service\GetRobotInActionAdminDetail;

use App\Exceptions\UserException;
use App\Core\Domain\Repository\PembayaranRepositoryInterface;
use App\Core\Domain\Models\RobotInAction\Team\RobotInActionTeamId;
use App\Core\Domain\Repository\StatusPembayaranRepositoryInterface;
use App\Core\Domain\Repository\RobotInActionTeamRepositoryInterface;
use App\Core\Domain\Repository\RobotInActionMemberRepositoryInterface;

class GetRobotInActionAdminDetailService
{
    private RobotInActionTeamRepositoryInterface $robot_in_action_team_repository;
    private RobotInActionMemberRepositoryInterface $robot_in_action_member_repository;
    private StatusPembayaranRepositoryInterface $status_pembayaran_repository;
    private PembayaranRepositoryInterface $pembayaran_repository;

    public function __construct(RobotInActionTeamRepositoryInterface $robot_in_action_team_repository, RobotInActionMemberRepositoryInterface $robot_in_action_member_repository, StatusPembayaranRepositoryInterface $status_pembayaran_repository, PembayaranRepositoryInterface $pembayaran_repository)
    {
        $this->robot_in_action_team_repository = $robot_in_action_team_repository;
        $this->robot_in_action_member_repository = $robot_in_action_member_repository;
        $this->status_pembayaran_repository = $status_pembayaran_repository;
        $this->pembayaran_repository = $pembayaran_repository;
    }

    public function execute(string $team_id): GetRobotInActionAdminDetailResponse
    {
        $id = new robotInActionTeamId($team_id);
        $team = $this->robot_in_action_team_repository->find($id);
        if (!$team) {
            UserException::throw("Team Id Tidak ditemukan", 6060);
        }
        $members = $this->robot_in_action_member_repository->findAllMember($id);

        $member_array = [];
        foreach ($members as $member) {
            $nama = $member->getName();
            $ketua = $member->getMemberType()->value;
            $no_telp = $member->getNoTelp();
            $id_card_url = $member->getIdCardUrl();
            $follow_sosmed_url = $member->getFollowSosmedUrl();
            $share_poster_url = $member->getSharePosterUrl();

            $memb = new GetRobotInActionAdminDetailTeamMemberResponse($nama, $ketua, $no_telp, $id_card_url, $follow_sosmed_url, $share_poster_url);
            array_push($member_array, $memb);
        }

        $payment_id = $team->getPembayaranId();

        if ($payment_id->toString() == null) {
            $payment_status = "AWAITING PAYMENT";

            $payment_obj = new PembayaranObjResponse($payment_status);

            $final = new GetRobotInActionAdminDetailResponse($team->getTeamName(), $team->getTeamCode(), $payment_obj, $member_array);
            return $final;
        } else {
            $payment = $this->pembayaran_repository->find($payment_id);
            $payment_status = $this->status_pembayaran_repository->find($payment->getStatusPembayaranId())->getStatus();
            $payment_image_url = $payment->getBuktiPembayaranUrl();

            $payment_obj = new PembayaranObjResponse($payment_status, $payment_id->toString(), $payment_image_url);

            $final = new GetRobotInActionAdminDetailResponse($team->getTeamName(), $team->getTeamCode(), $payment_obj, $member_array);
            return $final;
        }
    }
}
