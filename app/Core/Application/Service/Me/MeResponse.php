<?php

namespace App\Core\Application\Service\Me;

use App\Core\Domain\Models\User\User;
use JsonSerializable;

class MeResponse implements JsonSerializable
{
    private User $user;
    private string $role;
    private array $routes;
    private array $pre_event;
    private array $main_event;

    /**
     * @param User $user
     * @param string $role
     * @param array $routes
     * @param array $pre_event
     * @param array $main_event
     */
  public function __construct(
        User $user,
        string $role,
        array $routes,
        array $pre_event,
        array $main_event)
    {
        $this->user = $user;
        $this->role = $role;
        $this->routes = $routes;
        $this->pre_event = $pre_event;
        $this->main_event = $main_event;
    }

    public function jsonSerialize(): array
    {
        $response = [
            'name' => $this->user->getName(),
            'email' => $this->user->getEmail()->toString(),
            'no_telp' => $this->user->getNoTelp(),
            'permission' => [
                'role_id' => $this->user->getRoleId(),
                'role' => $this->role,
                'routes' => $this->routes,
            ],
            'pre_event' => $this->pre_event,
            'main_event' => $this->main_event 
        ];
        return $response;
    }
}
