<?php

namespace App\Core\Application\Service\RegisterKTIMember;

use App\Exceptions\UserException;
use App\Core\Domain\Models\UserAccount;
use App\Core\Domain\Models\KTI\KTIMemberType;
use App\Core\Domain\Models\KTI\Member\KTIMember;
use App\Core\Domain\Repository\KTITeamRepositoryInterface;
use App\Core\Domain\Repository\KTIMemberRepositoryInterface;
use App\Core\Domain\Models\UserHasListEvent\UserHasListEvent;
use App\Core\Domain\Repository\UserHasListEventRepositoryInterface;

class RegisterKTIMemberService
{
    private KTITeamRepositoryInterface $kti_team_repository;
    private KTIMemberRepositoryInterface $kti_member_repository;
    private UserHasListEventRepositoryInterface $user_has_list_event_repository;

    /**
     * @param KTITeamRepositoryInterface $kti_team_repository
     * @param KTIMemberRepositoryInferface $kti_member_repository
     * @param UserHasListEventRepositoryInterface $user_has_list_event_repository
     */
    public function __construct(KTITeamRepositoryInterface $kti_team_repository, KTIMemberRepositoryInterface $kti_member_repository, UserHasListEventRepositoryInterface $user_has_list_event_repository)
    {
        $this->kti_team_repository = $kti_team_repository;
        $this->kti_member_repository = $kti_member_repository;
        $this->user_has_list_event_repository  = $user_has_list_event_repository;
    }

    public function execute(array $requests, UserAccount $account)
    {
        $num_members = count($requests) + 1; // Cek ketua juga

        if ($num_members < 2) {
            UserException::throw("Kategori Lomba KTI Minimal 2 Anggota", 6002);
        } elseif ($num_members > 4) {
            UserException::throw("Kategori Lomba KTI Maksimal 4 Anggota", 6002);
        } else {
            $team_id = $this->kti_team_repository->findByUserId($account->getUserId());
            foreach ($requests as $request) {
                $member = KTIMember::create(
                    $team_id->getId(),
                    $request->getNama(),
                    $request->getNoTelp(),
                    KTIMemberType::MEMBER
                );
                $this->kti_member_repository->persist($member);

                $user_has_list_event = UserHasListEvent::create(
                    12,
                    $team_id->getUserId()
                );
                $this->user_has_list_event_repository->persist($user_has_list_event);
            }
        }
    }
}
