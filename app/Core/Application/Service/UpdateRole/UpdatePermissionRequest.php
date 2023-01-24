<?php

namespace App\Core\Application\Service\UpdatePermission;

class UpdatePermissionRequest
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

     public function getRoutes(): string
     {
        return $this->routes;
     }

     public function getId(): string
     {
      return $this->id;
     }
}