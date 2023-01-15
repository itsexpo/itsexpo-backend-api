<?php

namespace App\Core\Domain\Models\Role;

use Exception;
use App\Core\Domain\Models\User\UserId;

class Role
{
    private RoleId $id;
    private UserId $user_id;
    private string $name;

    /**
     * @param RoleId $id
     * @param UserId $user_id
     * @param string $name
     */
    public function __construct(RoleId $id, UserId $user_id, string $name)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->name = $name;
    }

    /**
     * @throws Exception
     */
    public static function create(UserId $user_id, string $name): self
    {
        return new self(
            RoleId::generate(),
            $user_id,
            $name,
        );
    }

    /**
     * @return RoleId
     */
    public function getId(): RoleId
    {
        return $this->id;
    }

    /**
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->user_id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
