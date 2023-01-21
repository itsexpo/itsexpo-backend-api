<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\PasswordReset\PasswordReset;

interface PasswordResetRepositoryInterface
{
    public function persist(PasswordReset $password_reset): void;

    public function findByEmail(string $email): ?PasswordReset;
}
