<?php

namespace App\Core\Application\Service\JoinTeamRobotInAction;

class JoinTeamRobotInActionRequest
{
    private string $code_team;

    public function __construct(string $code_team)
    {
        $this->code_team = $code_team;
    }

    public function getCodeTeam()
    {
        return $this->code_team;
    }
}
