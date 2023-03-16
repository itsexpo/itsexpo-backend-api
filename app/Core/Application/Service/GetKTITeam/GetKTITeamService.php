<?php 

namespace App\Core\Application\Service\GetKTITeam;

use App\Core\Domain\Models\UserAccount;
use App\Core\Domain\Repository\KTITeamRepositoryInterface;
use App\Core\Domain\Repository\KTIMemberRepositoryInterface;
use App\Core\Domain\Repository\PembayaranRepositoryInterface;
use App\Core\Domain\Repository\StatusPembayaranRepositoryInterface;
use App\Core\Domain\Repository\UserRepositoryInterface;

class GetKTITeamService
{
    private KTITeamRepositoryInterface $kti_team_repo;
    private KTIMemberRepositoryInterface $kti_member_repo;
    private StatusPembayaranRepositoryInterface $status_pembayaran_repo;
    private PembayaranRepositoryInterface $pembayaran_repo;
    private UserRepositoryInterface $user_repo;

    public function __construct(KTITeamRepositoryInterface $kti_team_repo, KTIMemberRepositoryInterface $kti_member_repo, StatusPembayaranRepositoryInterface $status_pembayaran_repo, PembayaranRepositoryInterface $pembayaran_repo, UserRepositoryInterface $user_repo)
    {
        $this->kti_team_repo = $kti_team_repo;
        $this->kti_member_repo = $kti_member_repo;
        $this->status_pembayaran_repo = $status_pembayaran_repo;
        $this->pembayaran_repo = $pembayaran_repo;
        $this->user_repo = $user_repo;
    }

    public function execute(UserAccount $account)
    {
        $user_id = $account->getUserId();
        $team = $this->kti_team_repo->findByUserId($user_id);

        $payment_id = $team->getPembayaranId();
        $payment = $this->pembayaran_repo->find($payment_id);
        $payment_status = $this->status_pembayaran_repo->find($payment->getStatusPembayaranId());

        $payment = new PembayaranObjResponse($payment_status->getStatus(), $payment_id->toString());

        $members = $this->kti_member_repo->findByTeamId($team->getId());

        $members_array = [];
        foreach ($members as $member) {
            $name = $member->getName();
            $no_telp = $member->getNoTelp();
            $memb = new GetKTITeamMemberResponse($name, $no_telp);
            array_push($members_array, $memb);
        }

        $lead_name = $this->kti_member_repo->findLeadByTeamId($team->getId())->getName();
        // $lead_no_telp = $this->user_repo->find($team->getUserId())->getNoTelp();
        $lead_no_telp = $this->kti_member_repo->findLeadByTeamId($team->getId())->getNoTelp();

        $final = new GetKTITeamResponse($team->getTeamName(), $team->getAsalInstansi(), $lead_name, $lead_no_telp, $payment, $members_array, $team->getFollowSosmed(), $team->getBuktiRepost(), $team->getTwibbon(), $team->getAbstrak());

        return $final;
    }
}