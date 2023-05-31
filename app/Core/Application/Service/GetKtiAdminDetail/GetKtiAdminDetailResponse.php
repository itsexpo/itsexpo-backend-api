<?php

namespace App\Core\Application\Service\GetKtiAdminDetail;

use JsonSerializable;

class GetKtiAdminDetailResponse implements JsonSerializable
{
    private string $team_name;
    private string $team_code;
    private string $asal_instansi;
    private string $follow_sosmed;
    private string $bukti_repost;
    private string $twibbon;
    private string $abstrak;
    private string $fullpaper;
    private PembayaranObjResponse $payment;
    private array $team_member;

    public function __construct(
        string $team_name,
        string $team_code,
        string $asal_instansi,
        string $follow_sosmed,
        string $bukti_repost,
        string $twibbon,
        string $abstrak,
        string $fullpaper,
        PembayaranObjResponse $payment,
        array $team_members,
    ) {
        $this->team_name = $team_name;
        $this->team_code = $team_code;
        $this->asal_instansi = $asal_instansi;
        $this->follow_sosmed = $follow_sosmed;
        $this->bukti_repost = $bukti_repost;
        $this->twibbon = $twibbon;
        $this->abstrak = $abstrak;
        $this->fullpaper = $fullpaper;
        $this->payment = $payment;
        $this->team_member = $team_members;
    }

    public function jsonSerialize(): array
    {
        return [
            'team_name' => $this->team_name,
            'team_code' => $this->team_code,
            'asal_instansi' => $this->asal_instansi,
            'follow_sosmed' => $this->follow_sosmed,
            'bukti_repost' => $this->bukti_repost,
            'twibbon' => $this->twibbon,
            'abstrak' => $this->abstrak,
            'fullpaper' => $this->fullpaper,
            'payment' => $this->payment,
            'team_member' => $this->team_member,
        ];
    }
}
