<?php

namespace App\Core\Application\Service\RegisterJurnalistikTeam;

use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikTeam;
use App\Core\Domain\Repository\JurnalistikTeamRepositoryInterface;

class RegisterJurnalistikTeamService
{
    private JurnalistikTeamRepositoryInterface $jurnalistik_team_repository;

    /**
     * @param JurnalistikTeamRepositoryInterface $jurnalistik_team_repository
     */
    public function __construct(JurnalistikTeamRepositoryInterface $jurnalistik_team_repository)
    {
        $this->jurnalistik_team_repository = $jurnalistik_team_repository;
    }

    public function execute(RegisterJurnalistikTeamRequest $request)
    {
        $team = JurnalistikTeam::create(
            null,
            $request->getTeamName(),
            $request->getTeamCode(),
            false,
            $request->getJumlahAnggota(),
            $request->getLombaCategory(),
            $request->getJenisKegiatan()
        );

        $this->jurnalistik_team_repository->persist($team);
    }
}
