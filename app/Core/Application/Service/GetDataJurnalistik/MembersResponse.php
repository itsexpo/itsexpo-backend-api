<?php

namespace App\Core\Application\Service\GetDataJurnalistik;

use App\Core\Domain\Models\Jurnalistik\JurnalistikMemberType;
use App\Core\Domain\Models\Jurnalistik\Member\JurnalistikMember;

use JsonSerializable;

class MembersResponse implements JsonSerializable
{
    private JurnalistikMember $jurnalistik_member;

    public function __construct(JurnalistikMember $jurnalistik_member)
    {
        $this->jurnalistik_member = $jurnalistik_member;
    }

    private function cekKetua(): bool
    {
        if ($this->jurnalistik_member->getMemberType() == JurnalistikMemberType::KETUA) {
            return true;
        }
        return false;
    }

    public function jsonSerialize(): array
    {
        $response = [
            'id' => $this->jurnalistik_member->getId()->toString(),
            'user_id' => $this->jurnalistik_member->getUserId()->toString(),
            'name' => $this->jurnalistik_member->getName(),
            'ketua' => $this->cekKetua()
        ];
        return $response;
    }
}
