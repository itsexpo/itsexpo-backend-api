<?php

namespace App\Core\Application\Service\KTIAdminPass;

class KTIAdminPassRequest
{
    private string $kti_team_id;
    private bool $lolos_paper;

    /**
     * @param string $kti_team_id
     * @param bool $lolos_paper
     */
    public function __construct(string $kti_team_id, bool $lolos_paper)
    {
        $this->kti_team_id = $kti_team_id;
        $this->lolos_paper = $lolos_paper;
    }

    /**
     * @return string
     */
    public function getTeamId(): string
    {
        return $this->kti_team_id;
    }

    /**
     * @return int
     */
    public function isLolosPaper(): bool
    {
        return $this->lolos_paper;
    }
}
