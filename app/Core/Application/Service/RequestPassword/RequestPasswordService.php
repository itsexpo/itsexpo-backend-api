<?php

namespace App\Core\Application\Service\RequestPassword;

use App\Exceptions\UserException;
use Illuminate\Support\Facades\Mail;
use App\Infrastrucutre\Service\JwtManager;
use App\Core\Application\Mail\RequestPasswordEmail;
use App\Core\Domain\Models\PasswordReset\PasswordReset;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Domain\Repository\PasswordResetRepositoryInterface;

class RequestPasswordService
{
    private $user_repository;
    private $password_reset_repository;

    public function __construct(
        UserRepositoryInterface $user_repository,
        PasswordResetRepositoryInterface $password_reset_repository
    ) {
        $this->user_repository = $user_repository;
        $this->password_reset_repository = $password_reset_repository;
    }

    public function execute(RequestPasswordRequest $input)
    {
        $email = $input->getEmail();
        $user = $this->user_repository->findByEmail($email);
        // check is valid
        $isValid = $user->getIsValid();
        if (!$isValid) {
            UserException::throw("User belum melakukan verifikasi", 6666, 404);
        }
        // create token
        $jwt_manager = new JwtManager($this->user_repository);
        $token = $jwt_manager->createForgotPasswordToken($user, $input->getIp()->getIP());
        // save to db
        $password_reset = new PasswordReset(
            $email,
            $token
        );
        $this->password_reset_repository->persist($password_reset);
        // send email
        Mail::to($user->getEmail()->toString())->send(new RequestPasswordEmail(
            $token,
        ));
    }
}
