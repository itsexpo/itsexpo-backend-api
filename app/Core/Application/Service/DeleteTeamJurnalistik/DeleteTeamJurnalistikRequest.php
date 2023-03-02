<?php

namespace App\Core\Application\Service\DeleteTeamJurnalistik;

class DeleteTeamJurnalistikRequest
{
    private string $code_team;
    private string $id_personal;

    public function __construct(string $code_team, string $id_personal)
    {
        $this->code_team = $code_team;
        $this->id_personal = $id_personal;
    }

    /**
     * Get the value of code_team
     */
    public function getCodeTeam()
    {
        return $this->code_team;
    }

    /**
     * Get the value of id_personal
     */
    public function getIdPersonal()
    {
        return $this->id_personal;
    }
}
