<?php

namespace App\Core\Application\Service\DeleteRoleHasPermission;

class DeleteRoleHasPermissionRequest
{
    private string $rhp_id;

    /**
     * @param string $rhp_id
     */

     public function __construct(string $rhp_id)
     {
        $this->rhp_id = $rhp_id;
     }

     public function getRoleHasPermissionId(): string
     {
        return $this->rhp_id;
     }
}