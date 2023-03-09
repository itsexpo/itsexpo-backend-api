<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Models\UserHasListEvent\UserHasListEvent;

interface UserHasListEventRepositoryInterface
{
    public function persist(UserHasListEvent $user_has_list_event): void;

    public function findByUserId(UserId $id): ?array;

    public function findByUserIdReturningOnlyEventsId(UserId $user_id): ?array;
}
