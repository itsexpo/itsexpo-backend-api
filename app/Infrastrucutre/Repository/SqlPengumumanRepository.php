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

        return $rows->all();
    }

    public function getByEventId(int $event_id): array
    {
        $rows = DB::table('pengumuman')->where('list_event_id', $event_id)->get();

        if (!$rows) {
            return null;
        }

        return $rows->all();
    }

    public function getById(string $id)
    {
        $row = DB::table('pengumuman')->where('id', $id)->first();

        if (!$row) {
            return null;
        }
        
        return $row;
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
}
