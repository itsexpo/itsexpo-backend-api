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
        $row = DB::table('user_has_list_event')->where('user_id', $user_id->toString())->get();

        return $this->constructFromRows($row->all());
    }

    public function findByUserIdReturningOnlyEventsId(UserId $user_id): ?array
    {
        $events_id = [];
        $row = DB::table('user_has_list_event')->where('user_id', $user_id->toString())->get();

        foreach ($row as $r) {
            array_push($events_id, $r->list_event_id);
        }

        return $events_id;
    }

    /**
     * @throws Exception
     */
    private function constructFromRows(array $rows): array
    {
        $user_has_list_event = [];
        foreach ($rows as $row) {
            $user_id = new UserId($row->user_id);
            $user_has_list_event[] = new UserHasListEvent(
                $row->list_event_id,
                $user_id,
            );
        }
        return $user_has_list_event;
    }
}
