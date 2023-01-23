<?php

namespace App\Core\Application\Service\GetUserList;

use JsonSerializable;
use App\Core\Domain\Models\User\User;

class GetUserListResponse implements JsonSerializable
{
    private User $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function jsonSerialize(): array
    {
        return [
            'user' => $this->user
        ];
    }
}
