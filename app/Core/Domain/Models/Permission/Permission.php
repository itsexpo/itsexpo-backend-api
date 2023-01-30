<?php

namespace App\Core\Domain\Models\Permission;

use Exception;

class Permission
{
    private string $id;
    private string $routes;

    /**
     * @param string $id
     * @param string $routes
     */
    public function __construct(string $id, string $routes)
    {
        $this->id = $id;
        $this->routes = $routes;
    }

    /**
     * @throws Exception
     */
    public static function create(string $routes, string $id): self
    {
        return new self(
            $id,
            $routes,
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
    public function getRoutes(): string
    {
        return $this->routes;
    }
}
