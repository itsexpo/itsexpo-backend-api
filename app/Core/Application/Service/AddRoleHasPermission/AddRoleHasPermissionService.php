<?php

namespace App\Core\Application\Service\AddRoleHasPermission;

use Exception;
use App\Core\Domain\Models\RoleHasPermission\RoleHasPermission;
use App\Core\Domain\Repository\RoleHasPermissionRepositoryInterface;

class AddRoleHasPermissionService 
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
    public function execute(AddRoleHasPermissionRequest $request)
    {
        $role_has_permission = RoleHasPermission::create( 
            $request->getRoleId(), 
            $request->getPermissionId() 
        );
        
        $this->role_has_permission_repository->persist( $role_has_permission );
    }
}