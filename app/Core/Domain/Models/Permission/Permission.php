<?php

namespace App\Core\Domain\Models\Permission;

use Exception;

class Permission
{
    private PermissionId $id;
    private string $routes;

    /**
     * @param PermissionId $id
     * @param string $routes
     */
    public function __construct(PermissionId $id, string $routes)
    {
        $this->id = $id;
        $this->routes = $routes;
    }

    /**
     * @throws Exception
     */
    public static function create(string $routes): self
    {
        return new self(
            PermissionId::generate(),
            $routes,
        );
    }

    /**
     * @return PermissionId
     */
    public function getId(): PermissionId
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getRoutes(): string
    {
        return $this->routes;
    }
}
