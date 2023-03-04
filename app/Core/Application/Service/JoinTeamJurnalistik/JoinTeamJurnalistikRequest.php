<?php

namespace App\Core\Application\Service\JoinTeamJurnalistik;

class JoinTeamJurnalistikRequest
{
    private string $code_team;

    public function __construct(string $code_team)
    {
        $this->code_team = $code_team;
    }

    /**
     * Get the value of code_team
     */
    public function getCodeTeam()
    {
        return $this->code_team;
    }
}
