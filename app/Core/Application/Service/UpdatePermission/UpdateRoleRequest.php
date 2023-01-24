<?php

namespace App\Core\Application\Service\UpdateRole;

class UpdateRoleRequest
{
    private string $id;
    private string $name;

    /**
     * @param string $id
     * @param string $name
     */

     public function __construct(string $id, string $name)
     {
        $this->id = $id;
        $this->name = $name;
     }

     public function getName(): string
     {
        return $this->name;
     }

     public function getId(): string
     {
      return $this->id;
     }
}