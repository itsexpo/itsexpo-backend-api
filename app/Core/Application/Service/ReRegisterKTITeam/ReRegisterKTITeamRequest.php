<?php

namespace App\Core\Application\Service\ReRegisterKTITeam;

use App\Core\Domain\Models\KTI\Team\KTITeamId;
use Illuminate\Http\UploadedFile;

class ReRegisterKTITeamRequest
{
    private KTITeamId $kti_team_id;
    private UploadedFile $file_paper;

    /**
     * @param UploadedFile $file_paper
     */

    public function __construct(string $kti_team_id, UploadedFile $file_paper)
    {
        $this->kti_team_id = new KTITeamId($kti_team_id);
        $this->file_paper = $file_paper;
    }

     /**
      * @return UploadedFile
      */

    public function getFilePaper(): UploadedFile
    {
        return $this->file_paper;
    }

    /**
     * @return KTITeamId
     */
    public function getKTITeamId(): KTITeamId
    {
        return $this->kti_team_id;
    }
}
