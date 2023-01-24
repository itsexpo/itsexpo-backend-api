<?php

namespace App\Core\Application\Service\GetPermissionList;

use JsonSerializable;
use App\Core\Domain\Models\Permission\Permission;

class GetPermissionListResponse implements JsonSerializable
{
    private Permission $role;

    /**
     * @param Permission $role
     */
    public function __construct(Permission $role)
    {
        $this->role = $role;
    }

    public function jsonSerialize(): array
    {
        return [
            'role' => $this->role
        ];
    }
}
