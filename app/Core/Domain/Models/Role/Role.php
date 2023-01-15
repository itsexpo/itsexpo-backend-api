<?php

namespace App\Core\Domain\Models\Role;

use Exception;

class Role
{
    private string $id;
    private string $name;

    /**
     * @param string $id
     * @param UserId $user_id
     * @param string $name
     */
    public function __construct(string $id, string $name)
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
            string::generate(),
            $name,
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
    public function getName(): string
    {
        return $this->name;
    }
}
