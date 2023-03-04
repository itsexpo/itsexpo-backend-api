<?php

namespace App\Infrastrucutre\Repository;

use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\ListEvent\ListEvent;
use App\Core\Domain\Repository\ListEventRepositoryInterface;
use Illuminate\Support\Facades\Date;

class SqlListEventRepository implements ListEventRepositoryInterface
{
    public function getAll(): array
    {
        $rows = DB::table('list_event')->get();

        return $this->constructFromRows($rows->toArray());
    }

    public function find(int $list_event_id): ?ListEvent
    {
        $row = DB::table('list_event')->where('id', $list_event_id)->first();

        return $this->constructFromRows([$row])[0];
    }

    /**
     * @throws Exception
     */
    private function constructFromRows(array $rows): array
    {
        $list_event = [];
        foreach ($rows as $row) {
            $list_event[] = new ListEvent(
                $row->id,
                $row->name,
                $row->kuota,
                Date::parse($row->created_at),
                Date::parse($row->updated_at)
            );
        }

        return $list_event;
    }
}
