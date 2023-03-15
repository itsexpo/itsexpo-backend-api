<?php

namespace App\Core\Application\Service\RegisterKTIMember;

use App\Core\Domain\Models\KTI\KTIMemberType;
use App\Core\Domain\Models\KTI\Member\KTIMember;
use App\Core\Domain\Models\UserAccount;
use App\Core\Domain\Repository\KTIMemberRepositoryInterface;
use App\Core\Domain\Repository\KTITeamRepositoryInterface;

class RegisterKTIMemberService
{
    private KTITeamRepositoryInterface $kti_team_repository;
    private KTIMemberRepositoryInterface $kti_member_repository;

    /**
     * @param KTITeamRepositoryInterface $kti_team_repository
     * @param KTIMemberRepositoryInferface $kti_member_repository
     */
    public function __construct(KTITeamRepositoryInterface $kti_team_repository, KTIMemberRepositoryInterface $kti_member_repository)
    {
        $this->kti_team_repository = $kti_team_repository;
        $this->kti_member_repository = $kti_member_repository;
    }

    public function execute(array $requests, UserAccount $account)
    {
        $team_id = $this->kti_team_repository->findByUserId($account->getUserId());
        foreach ($requests as $request) {
            $member = KTIMember::create(
                $team_id->getId(),
                $request->getNama(),
                $request->getNoTelp(),
                KTIMemberType::MEMBER
            );

            $this->kti_member_repository->persist($member);
        }
    }
}
