<?php

namespace App\Core\Application\Service\GetKTITeam;

use App\Core\Domain\Models\KTI\Team\KTITeamId;
use Illuminate\Http\UploadedFile;
use JsonSerializable;

class GetKTITeamResponse implements JsonSerializable
{
    private string $team_id;
    private string $team_name;
    private string $asal_instansi;
    private string $lead_name;
    private string $no_telp;
    private PembayaranObjResponse $payment;
    private array $members;
    private string $follow_sosmed;
    private string $share_poster;
    private string $twibbon;
    private string $abstrak;
    private bool $lolos_paper;
    private string $full_paper;

    public function __construct(string $team_id, string $team_name, string $asal_instansi, string $lead_name, string $no_telp, PembayaranObjResponse $payment, array $members, string $follow_sosmed, string $share_poster, string $twibbon, string $abstrak, bool $lolos_paper, string $full_paper)
    {
        $this->team_id = $team_id;
        $this->team_name = $team_name;
        $this->asal_instansi = $asal_instansi;
        $this->lead_name = $lead_name;
        $this->no_telp = $no_telp;
        $this->payment = $payment;
        $this->members = $members;
        $this->follow_sosmed = $follow_sosmed;
        $this->share_poster = $share_poster;
        $this->twibbon = $twibbon;
        $this->abstrak = $abstrak;
        $this->lolos_paper = $lolos_paper;
        $this->full_paper = $full_paper;
    }

    public function jsonSerialize(): array
    {
        return [
            'team_id' => $this->team_id,
            'team_name' => $this->team_name,
            'asal_instansi' => $this->asal_instansi,
            'lead_name' => $this->lead_name,
            'no_telp' => $this->no_telp,
            'payment' => $this->payment,
            'members' => $this->members,
            'follow_sosmed' => $this->follow_sosmed,
            'share_poster' => $this->share_poster,
            'twibbon' => $this->twibbon,
            'abstrak' => $this->abstrak,
            'lolos_paper' => $this->lolos_paper,
            'full_paper' => $this->full_paper
        ];
    }
}
