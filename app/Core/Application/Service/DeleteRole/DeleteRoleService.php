<?php

namespace App\Core\Application\Service\DeleteRole;

use Exception;
use App\Core\Domain\Repository\RoleRepositoryInterface;

class DeleteRoleService 
{
    private RoleRepositoryInterface $role_repository;

    /**
     * @param RoleRepositoryInterface $role_repository
     */

    public function __construct(RoleRepositoryInterface $role_repository)
    {
        $this->role_repository = $role_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(DeleteRoleRequest $request)
    {
        $this->role_repository->delete( $request->getRoleId() );
    }
}