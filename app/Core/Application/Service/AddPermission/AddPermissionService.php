<?php

namespace App\Core\Application\Service\AddPermission;

use Exception;
use App\Core\Domain\Models\Permission\Permission;
use App\Core\Domain\Repository\PermissionRepositoryInterface;

class AddPermissionService 
{
    private PermissionRepositoryInterface $permission_repository;

    /**
     * @param PermissionRepositoryInterface $permission_repository
     */

    public function __construct(PermissionRepositoryInterface $permission_repository)
    {
        $this->permission_repository = $permission_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(AddPermissionRequest $request)
    {
        $permission = Permission::create( $request->getRoutes() );
        $this->permission_repository->persist( $permission );
    }
}