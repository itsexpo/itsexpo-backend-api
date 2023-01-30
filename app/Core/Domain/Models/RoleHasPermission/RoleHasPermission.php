<?php

namespace App\Core\Domain\Models\RoleHasPermission;

use Exception;

class RoleHasPermission
{
    private string $id;
    private string $role_id;
    private string $permission_id;

    /**
     * @param string $role_id
     * @param string $permission_id
     * @param string $id
     */
    public function __construct(string $id, string $role_id, string $permission_id)
    {
        $this->id = $id;
        $this->role_id = $role_id;
        $this->permission_id = $permission_id;
    }

    /**
     * @throws Exception
     */
    public static function create(string $id, string $role_id, string $permission_id): self
    {
        return new self(
            $id,
            $role_id,
            $permission_id,
        );
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getRoleId(): string
    {
        return $this->role_id;
    }

    /**
     * @return string
     */
    public function getPermissionId(): string
    {
        return $this->permission_id;
    }
}
