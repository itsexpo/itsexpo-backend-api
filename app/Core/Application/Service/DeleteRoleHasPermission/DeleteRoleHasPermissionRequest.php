<?php

namespace App\Core\Application\Service\DeleteRoleHasPermission;

class DeleteRoleHasPermissionRequest
{
    private string $role_id;
    private string $permission_id;

    /**
     * @param string $role_id
     * @param string $permission_id
     */

    public function __construct(string $role_id, string $permission_id)
    {
        $this->role_id = $role_id;
        $this->permission_id = $permission_id;
    }

    public function getRoleId(): string
    {
        return $this->role_id;
    }

    public function getPermissionId(): string
    {
        return $this->permission_id;
    }
}
