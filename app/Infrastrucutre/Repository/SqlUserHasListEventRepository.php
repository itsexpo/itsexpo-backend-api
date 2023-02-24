<?php

namespace App\Infrastrucutre\Repository;

use App\Core\Domain\Models\User\UserId;
use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\UserHasListEvent\UserHasListEvent;
use App\Core\Domain\Repository\UserHasListEventRepositoryInterface;

class SqlUserHasListEventRepository implements UserHasListEventRepositoryInterface
{
    public function findByUserId(UserId $user_id): ?array
    {
        $row = DB::table('user_has_list_event')->where('user_id', $user_id)->get();

        return $this->constructFromRows($row->all());
    }

    /**
     * @throws Exception
     */
    private function constructFromRows(array $rows): array
    {
        $user_has_list_event = [];
        foreach ($rows as $row) {
            $user_has_list_event[] = new UserHasListEvent(
                $row->list_event_id,
                $row->user_id,
            );
        }
        return $user_has_list_event;
    }
}
