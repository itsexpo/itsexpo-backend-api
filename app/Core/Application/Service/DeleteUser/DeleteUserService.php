<?php

namespace App\Core\Application\Service\DeleteUser;

use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Application\Service\DeleteUser\DeleteUserRequest;

class DeleteUserService 
{
    private UserRepositoryInterface $user_repository;

    /**
     * @param UserRepositoryInterface $user_repository
     */
    
    public function __construct(UserRepositoryInterface $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(DeleteUserRequest $request)
    {

    }
}