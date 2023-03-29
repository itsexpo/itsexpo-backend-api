<?php

namespace App\Infrastrucutre\Repository;

use App\Core\Domain\Models\Pengumuman\Pengumuman;
use App\Core\Domain\Models\Pengumuman\PengumumanId;
use App\Core\Domain\Repository\PengumumanRepositoryInterface;
use Illuminate\Support\Facades\DB;

class SqlPengumumanRepository implements PengumumanRepositoryInterface
{
    public function persist(Pengumuman $pengumuman): void
    {
        DB::table('pengumuman')->upsert([
            'id' => $pengumuman->getId()->toString(),
            'list_event_id' => $pengumuman->getListEventId(),
            'title' => $pengumuman->getTitle(),
            'description' => $pengumuman->getDescription()
        ], 'id');
    }

    public function getAll(): array
    {
        $rows = DB::table('pengumuman')->get();

        if (!$rows) {
            return null;
        }

        return $this->constructFromRows($rows->all());
    }

    public function getByEventId(int $event_id): array
    {
        $rows = DB::table('pengumuman')->where('list_event_id', $event_id)->get();

        if (!$rows) {
            return null;
        }

        return $this->constructFromRows($rows->all());
    }

    public function getById(string $id): Pengumuman
    {
        $row = DB::table('pengumuman')->where('id', $id)->first();

        if (!$row) {
            return null;
        }
        
        return $this->constructFromRow($row);
    }

    public function update(PengumumanId $id, int $event_id, string $title, string $description): void
    {
        DB::table('pengumuman')
            ->where('id', '=', $id->toString())
            ->update([
                'list_event_id' => $event_id,
                'title' => $title,
                'description' => $description
            ]);
    }

    public function delete(PengumumanId $id): void
    {
        DB::table('pengumuman')->where('id', $id->toString())->delete();
    }

    public function getWithPagination(int $page, int $per_page): array
    {
        $rows = DB::table('pengumuman')
            ->paginate($per_page, ['*'], 'permission_page', $page);
        $permissions = [];

        foreach ($rows as $row) {
            $permissions[] = $this->constructFromRow($row);
        }
        return [
            "data" => $permissions,
            "max_page" => ceil($rows->total() / $per_page)
        ];
    }

    public function getByEventIdWithPagination(int $page, int $per_page, int $event_id): array
    {
        $rows = DB::table('pengumuman')->where('list_event_id', $event_id)
            ->paginate($per_page, ['*'], 'permission_page', $page);
        $permissions = [];

        foreach ($rows as $row) {
            $permissions[] = $this->constructFromRow($row);
        }
        return [
            "data" => $permissions,
            "max_page" => ceil($rows->total() / $per_page)
        ];
    }

    public function constructFromRow($row): Pengumuman
    {
        return new Pengumuman(
            new PengumumanId($row->id),
            $row->list_event_id,
            $row->title,
            $row->description,
            $row->created_at,
            $row->updated_at,
        );
    }

    private function constructFromRows(array $rows): array
    {
        $pengumuman = [];
        foreach ($rows as $row) {
            $pengumuman[] = new Pengumuman(
                new PengumumanId($row->id),
                $row->list_event_id,
                $row->title,
                $row->description,
                $row->created_at,
                $row->updated_at,
            );
        }
        return $pengumuman;
    }
}
