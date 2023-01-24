<?php

namespace App\Core\Application\Service\DeleteRoleHasPermission;

use Exception;
use App\Core\Domain\Repository\RoleHasPermissionRepositoryInterface;

class DeleteRoleHasPermissionService 
{
    private RoleHasPermissionRepositoryInterface $role_has_permission_repository;

    /**
     * @param RoleHasPermissionRepositoryInterface $role_has_permission_repository
     */

    public function __construct(RoleHasPermissionRepositoryInterface $role_has_permission_repository)
    {
        $this->role_has_permission_repository = $role_has_permission_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(DeleteRoleHasPermissionRequest $request)
    {
        $this->role_has_permission_repository->delete( $request->getRoleHasPermissionId() );
    }
}