<?php

namespace App\Core\Application\Service\DeleteRole;

class DeleteRoleRequest
{
    private string $role_id;

    /**
     * @param string $role_id
     */

     public function __construct(string $role_id)
     {
        $this->role_id = $role_id;
     }

     public function getRoleId(): string
     {
        return $this->role_id;
     }
}