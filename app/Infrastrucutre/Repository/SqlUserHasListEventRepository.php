<?php

namespace App\Infrastrucutre\Repository;

use App\Core\Domain\Models\User\UserId;
use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\UserHasListEvent\UserHasListEvent;
use App\Core\Domain\Models\UserHasListEvent\UserHasListEventId;
use App\Core\Domain\Repository\UserHasListEventRepositoryInterface;

class SqlUserHasListEventRepository implements UserHasListEventRepositoryInterface
{
    public function persist(UserHasListEvent $user_has_list_event): void
    {
        DB::table('user_has_list_event')->insert([
            'id' => $user_has_list_event->getId()->toString(),
            'list_event_id' => $user_has_list_event->getListEventId(),
            'user_id' => $user_has_list_event->getUserId()->toString()
        ]);
    }

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
            $user_has_list_event[] = new UserHasListEvent(
                new UserHasListEventId($row->id),
                $row->list_event_id,
                new UserId($row->user_id),
            );
        }
        return $user_has_list_event;
    }
}
