<?php

namespace App\Core\Application\Service\UpdatePermission;

use Exception;
use App\Core\Domain\Models\Permission\Permission;
use App\Core\Domain\Repository\PermissionRepositoryInterface;

class UpdatePermissionService 
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
    public function execute(UpdatePermissionRequest $request)
    {
        $permission = new Permission( 
            $request->getId(),
            $request->getRoutes()
        );
        
        $this->permission_repository->persist( $permission );
    }
}