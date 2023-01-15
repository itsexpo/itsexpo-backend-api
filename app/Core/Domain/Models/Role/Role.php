<?php

namespace App\Core\Domain\Models\Role;

use Exception;

class Role
{
    private RoleId $id;
    private string $name;

    /**
     * @param RoleId $id
     * @param UserId $user_id
     * @param string $name
     */
    public function __construct(RoleId $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @throws Exception
     */
    public static function create(string $name): self
    {
        return new self(
            RoleId::generate(),
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
