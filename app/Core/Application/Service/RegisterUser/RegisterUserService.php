<?php

namespace App\Core\Application\Service\RegisterUser;

use App\Core\Domain\Models\Email;
use App\Core\Domain\Models\User\User;
use App\Core\Domain\Repository\UserRepositoryInterface;
use Exception;

class RegisterUserService
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
    public function execute(RegisterUserRequest $request)
    {
        $user = User::create(
            1,
            new Email($request->getEmail()),
            $request->getNoTelp(),
            $request->getName(),
            false,
            $request->getPassword()
        );
        $this->user_repository->persist($user);
    }
}
