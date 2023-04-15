<?php

namespace App\Core\Application\Service\GetWahana3DAdminDetail;

use JsonSerializable;

class GetWahana3DAdminDetailResponse implements JsonSerializable
{
    private string $team_name;
    private string $team_code;
    private PembayaranObjResponse $payment;
    private array $team_members;

    public function __construct(
        string $team_name,
        string $team_code,
        PembayaranObjResponse $payment,
        array $team_members
    ) {
        $this->team_name = $team_name;
        $this->team_code = $team_code;
        $this->payment = $payment;
        $this->team_members = $team_members;
    }

    public function jsonSerialize(): array
    {
        return [
          'team_name' => $this->team_name,
          'team_code' => $this->team_code,
          'payment' => $this->payment,
          'team_member' => $this->team_members
        ];
    }
}
