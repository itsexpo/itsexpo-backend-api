<?php

namespace App\Core\Application\Service\DeletePermission;

use Exception;
use App\Core\Domain\Repository\PermissionRepositoryInterface;

class DeletePermissionService 
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
    public function execute(DeletePermissionRequest $request)
    {
        $this->permission_repository->delete( $request->getPermissionId() );
    }
}