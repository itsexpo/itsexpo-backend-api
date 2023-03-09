<?php

namespace App\Core\Application\Service\GetJurnalistikAdminDetail;

use App\Core\Domain\Repository\JurnalistikTeamRepositoryInterface;

class GetJurnalistikAdminDetailService
{
    private JurnalistikTeamRepositoryInterface $jurnalistik_team_repository;

    public function __construct(JurnalistikTeamRepositoryInterface $jurnalistik_team_repository)
    {
        $this->jurnalistik_team_repository = $jurnalistik_team_repository;
    }

    public function execute(string $team_id)
    {
    }
}
