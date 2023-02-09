<?php

namespace App\Core\Application\Service\GetRolePermission;

use JsonSerializable;

class GetRolePermissionResponse implements JsonSerializable
{
    private string $id;
    private string $route;

    /**
     * @param string $id
     * @param string $route
     */
    public function __construct(string $id, string $routes)
    {
        $this->id = $id;
        $this->route = $routes;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'route' => $this->route,
        ];
    }
}
