<?php 

namespace App\Core\Application\Service\GetKTIToken;

use App\Core\Domain\Models\UserAccount;
use App\Core\Domain\Repository\KTITeamRepositoryInterface;
use App\Core\Application\Service\GetKTIToken\GetKTITokenResponse;
use App\Exceptions\UserException;

class GetKTITokenService
{
    private KTITeamRepositoryInterface $kti_team_repo;

    public function __construct(KTITeamRepositoryInterface $kti_team_repo)
    {
        $this->kti_team_repo = $kti_team_repo;
    }

    public function execute(UserAccount $account)
    {
        $user_id = $account->getUserId();

        if (!$user_id) {
            UserException::throw("User id tidak ditemukan", 1005, 404);
        }

        $team = $this->kti_team_repo->findByUserId($user_id);

        if (!$team) {
            UserException::throw("Team tidak ditemukan", 1005, 404);
        }

        return GetKTITokenResponse (
            $team->getId()
        );

    }
}