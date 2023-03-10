<?php

namespace App\Core\Application\Service\GetJurnalistikAdminDetail;

use JsonSerializable;

class GetJurnalistikAdminDetailResponse implements JsonSerializable
{
    private string $team_name;
    private string $team_code;
    private string $payment_status;
    private string $payment_image;
    private array $team_member;

    public function __construct(
        string $team_name,
        string $team_code,
        string $payment_status,
        string $payment_image,
        GetJurnalistikAdminDetailTeamMemberResponse ...$team_members,
    ) {
        $this->team_name = $team_name;
        $this->team_code = $team_code;
        $payment = collect([
            $this->payment_status = $payment_status,
            $this->payment_image = $payment_image
        ]);
        foreach ($team_members as $team_member) {
            $this->team_member[] = $team_member;
        }
    }

    public function jsonSerialize(): array
    {
        $payment = collect([
            'status' => $this->payment_status,
            'image' => $this->payment_image
        ]);

        return [
            'team_name' => $this->team_name,
            'team_code' => $this->team_code,
            'payment' => $payment,
            'team_member' => $this->team_member,
        ];
    }
}
