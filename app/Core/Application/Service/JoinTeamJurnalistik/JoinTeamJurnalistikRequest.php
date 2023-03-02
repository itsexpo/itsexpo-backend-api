<?php

namespace App\Core\Application\Service\JoinTeamJurnalistik;

use App\Core\Domain\Models\UserAccount;

class JoinTeamJurnalistikRequest
{
    private string $code_team;
    private UserAccount $account;

    public function __construct(string $code_team, UserAccount $account)
    {
        $this->code_team = $code_team;
        $this->account = $account;
    }

    /**
     * Get the value of code_team
     */
    public function getCodeTeam()
    {
        return $this->code_team;
    }

    /**
     * Get the value of account
     */
    public function getAccount()
    {
        return $this->account;
    }
}
