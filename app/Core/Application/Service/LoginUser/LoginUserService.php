<?php

namespace App\Core\Application\Service\LoginUser;

use Exception;
use App\Core\Domain\Models\Email;
use App\Exceptions\UserException;
use Illuminate\Support\Facades\Mail;
use App\Core\Application\Mail\EmailTest;
use App\Core\Domain\Service\JwtManagerInterface;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Application\Service\LoginUser\LoginUserRequest;
use App\Core\Application\Service\LoginUser\LoginUserResponse;

class LoginUserService
{
    private UserRepositoryInterface $user_repository;
    private JwtManagerInterface $jwt_factory;

    /**
     * @param UserRepositoryInterface $user_repository
     * @param JwtManagerInterface $jwt_factory
     */
    public function __construct(UserRepositoryInterface $user_repository, JwtManagerInterface $jwt_factory)
    {
        $this->user_repository = $user_repository;
        $this->jwt_factory = $jwt_factory;
    }

    /**
     * @throws Exception
     */
    public function execute(LoginUserRequest $request): LoginUserResponse
    {
        $user = $this->user_repository->findByEmail(new Email($request->getEmail()));
        if (!$user) {
            UserException::throw("user tidak ketemu", 1006, 404);
        }
        $type = $this->user_repository->findByEmail(new Email($request->getEmail()))->getType();
        
        $user->beginVerification()
            ->checkPassword($request->getPassword())
            ->verify();
        $token_jwt = $this->jwt_factory->createFromUser($user);
        Mail::to($user->getEmail()->toString())->send(new EmailTest(
            $user->getName(),
            $user->getEmail()->toString(),
            $user->getNoTelp(),
        ));
        return new LoginUserResponse($token_jwt, $type);
    }
}
