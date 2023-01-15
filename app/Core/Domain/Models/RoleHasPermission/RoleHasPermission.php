<?php

namespace App\Core\Domain\Models\RoleHasPermission;

use Exception;
use App\Core\Domain\Models\Role\RoleId;
use App\Core\Domain\Models\Permission\PermissionId;

class RoleHasPermission
{
    private RoleHasPermissionId $id;
    private RoleId $role_id;
    private PermissionId $permission_id;

    /**
     * @param RoleId $role_id
     * @param PermissionId $permission_id
     * @param RoleHasPermissionId $id
     */
    public function __construct(RoleHasPermissionId $id, RoleId $role_id, PermissionId $permission_id)
    {
        $this->id = $id;
        $this->role_id = $role_id;
        $this->permission_id = $permission_id;
    }

    /**
     * @throws Exception
     */
    public static function create(RoleId $role_id, PermissionId $permission_id): self
    {
        return new self(
            RoleHasPermissionId::generate(),
            $role_id,
            $permission_id,
        );
    }

    /**
     * @return RoleHasPermissionId
     */
    public function getId(): RoleHasPermissionId
    {
        return $this->id;
    }

    /**
     * @return RoleId
     */
    public function getRoleId(): RoleId
    {
        return $this->role_id;
    }

    /**
     * @return PermissionId
     */
    public function getPermissionId(): PermissionId
    {
        return $this->permission_id;
    }
}
