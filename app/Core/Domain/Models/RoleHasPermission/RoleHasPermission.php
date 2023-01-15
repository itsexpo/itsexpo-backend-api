<?php

namespace App\Core\Domain\Models\RoleHasPermission;

use Exception;
use App\Core\Domain\Models\Role\RoleId;
use App\Core\Domain\Models\User\UserId;

class RoleHasPermission
{
    private RoleHasPermissionId $id;
    private RoleId $role_id;
    private UserId $user_id;

    /**
     * @param RoleId $role_id
     * @param UserId $user_id
     * @param RoleHasPermissionId $id
     */
    public function __construct(RoleHasPermissionId $id, RoleId $role_id, UserId $user_id)
    {
        $this->id = $id;
        $this->role_id = $role_id;
        $this->user_id = $user_id;
    }

    /**
     * @throws Exception
     */
    public static function create(RoleId $role_id, UserId $user_id): self
    {
        return new self(
            RoleHasPermissionId::generate(),
            $role_id,
            $user_id,
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
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->user_id;
    }
}
