<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\ListBank\ListBank;

interface ListBankRepositoryInterface
{
    public function find(int $id): ?ListBank;
}
