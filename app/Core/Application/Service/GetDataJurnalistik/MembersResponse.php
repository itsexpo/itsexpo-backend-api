<?php

namespace App\Core\Application\Service\GetDataJurnalistik;

use App\Core\Domain\Models\Jurnalistik\Member\JurnalistikMember;

use JsonSerializable;

class MembersResponse implements JsonSerializable
{
    private JurnalistikMember $jurnalistik_member;

    public function __construct(JurnalistikMember $jurnalistik_member)
    {
        $this->jurnalistik_member = $jurnalistik_member;
    }

    public function jsonSerialize(): array
    {
        $response = [
            'id' => $this->jurnalistik_member->getId()->toString(),
            'user_id' => $this->jurnalistik_member->getUserId()->toString(),
            'name' => $this->jurnalistik_member->getName()
        ];
        return $response;
    }
}
