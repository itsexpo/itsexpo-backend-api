<?php

namespace App\Core\Application\Service\GetWahana3DAdminDetail;

use JsonSerializable;

class GetWahana3DAdminDetailResponse implements JsonSerializable
{
    private string $team_name;
    private string $team_code;
    // private string $bukti_upload_ktm;
    private PembayaranObjResponse $payment;
    private array $team_members;

    public function __construct(
        string $team_name,
        string $team_code,
    // string $bukti_upload_ktm,
    PembayaranObjResponse $payment,
        array $team_members
    ) {
        $this->team_name = $team_name;
        $this->team_code = $team_code;
        // $this->bukti_upload_ktm = $bukti_upload_ktm;
        $this->payment = $payment;
        $this->team_members = $team_members;
    }

    public function jsonSerialize(): array
    {
        return [
          'team_name' => $this->team_name,
          'team_code' => $this->team_code,
          // 'bukti_upload_ktm' => $this->bukti_upload_ktm,
          'payment' => $this->payment,
          'team_member' => $this->team_members
        ];
    }
}
