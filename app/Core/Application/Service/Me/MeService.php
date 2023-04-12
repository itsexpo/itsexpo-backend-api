<?php

namespace App\Core\Application\Service\Me;

use App\Core\Domain\Models\ListEvent\ListEvent;
use Exception;
use App\Exceptions\UserException;
use App\Core\Domain\Models\UserAccount;
use App\Core\Domain\Repository\RoleRepositoryInterface;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Domain\Repository\ListEventRepositoryInterface;
use App\Core\Domain\Repository\PermissionRepositoryInterface;
use App\Core\Domain\Models\RoleHasPermission\RoleHasPermission;
use App\Core\Domain\Repository\UserHasListEventRepositoryInterface;
use App\Core\Domain\Repository\RoleHasPermissionRepositoryInterface;

class MeService
{
    private UserRepositoryInterface $user_repository;
    private RoleRepositoryInterface $role_repository;
    private PermissionRepositoryInterface $permission_repository;
    private RoleHasPermissionRepositoryInterface $role_has_permission_repository;
    private ListEventRepositoryInterface $list_event_repository;
    private UserHasListEventRepositoryInterface $user_has_list_event_repository;

    /**
     * @param UserRepositoryInterface $user_repository
     * @param RoleRepositoryInterface $role_repository
     * @param PermissionRepositoryInterface $permission_repository
     * @param RoleHasPermissionRepositoryInterface $role_has_permission_repository
     * @param ListEventRepositoryInterface $list_event_repository
     * @param UserHasListEventRepositoryInterface $user_has_list_event
     */
    public function __construct(
        UserRepositoryInterface $user_repository,
        RoleRepositoryInterface $role_repository,
        PermissionRepositoryInterface $permission_repository,
        RoleHasPermissionRepositoryInterface $role_has_permission_repository,
        ListEventRepositoryInterface $list_event_repository,
        UserHasListEventRepositoryInterface $user_has_list_event_repository
    ) {
        $this->user_repository = $user_repository;
        $this->role_repository = $role_repository;
        $this->permission_repository = $permission_repository;
        $this->role_has_permission_repository = $role_has_permission_repository;
        $this->list_event_repository = $list_event_repository;
        $this->user_has_list_event_repository = $user_has_list_event_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(UserAccount $account): MeResponse
    {
        $user = $this->user_repository->find($account->getUserId());
        $role = $this->role_repository->find($user->getRoleId());
        if (!$user) {
            UserException::throw("user tidak ditemukan", 1006, 404);
        }
        $user_events_id = $this->user_has_list_event_repository->findByUserIdReturningOnlyEventsId($account->getUserId());

        $list_event = $this->list_event_repository->getAll();

        $main_event_id = [51, 52];

        $user_main_event = []; 
        $user_pre_event = [];
        array_map(function (ListEvent $event) use ($user_events_id, $main_event_id, &$user_main_event, &$user_pre_event) {
            $status = in_array($event->getId(), $user_events_id);
            if(in_array($event->getId(), $main_event_id)){
              array_push($user_main_event, [
                $event->getName() => [
                  'status' => $status,
                  'start_date' => $event->getStartDate(),
                  'close_date' => $event->getCloseDate()
                ]
              ]);
            } else {
              array_push($user_pre_event, [
                $event->getName() => [
                  'status' => $status,
                  'start_date' => $event->getStartDate(),
                  'close_date' => $event->getCloseDate()
                ]
              ]);
            }
        }, $list_event);
        
        $routes = $this->role_has_permission_repository->findByRoleId($role->getId());
        $routes_array = array_map(function (RoleHasPermission $route) {
            return new RoutesResponse(
                $this->permission_repository->find($route->getPermissionId())->getRoutes()
            );
        }, $routes);

        // unset($user_has_event[4], $user_has_event[5]);
        // $user_has_event = array_values($user_has_event);

        return new MeResponse($user, $role->getName(), $routes_array, $user_pre_event, $user_main_event);
    }
}
