<?php

namespace App\Core\Application\Service\DeletePermission;

class DeletePermissionRequest
{
    private string $permission_id;

    /**
     * @param string $permission_id
     */

     public function __construct(string $permission_id)
     {
        $this->permission_id = $permission_id;
     }

     public function getPermissionId(): string
     {
        return $this->permission_id;
     }
}