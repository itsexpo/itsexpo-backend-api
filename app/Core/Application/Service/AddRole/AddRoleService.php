<?php

namespace App\Core\Application\Service\AddRole;

use Exception;
use App\Core\Domain\Models\Role\Role;
use App\Core\Domain\Repository\RoleRepositoryInterface;

class AddRoleService 
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
    public function execute(AddRoleRequest $request)
    {
        $role = Role::create( $request->getName() );
        $this->role_repository->persist( $role );
    }
}