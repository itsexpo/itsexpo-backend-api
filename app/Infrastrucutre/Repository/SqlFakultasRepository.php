<?php

namespace App\Infrastrucutre\Repository;

use App\Core\Domain\Models\Fakultas\Fakultas;
use App\Core\Domain\Repository\FakultasRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class SqlFakultasRepository implements FakultasRepositoryInterface
{
    /**
     * @throws Exception
     */
    public function getAll(): array
    {
        $rows = DB::table('fakultas')->get();

        return $this->constructFromRows($rows->all());
    }

    /**
     * @param array $rows
     * @return Fakultas[]
     * @throws Exception
     */
    public function constructFromRows(array $rows): array
    {
        $fakultas = [];
        foreach ($rows as $row) { 
            $fakultas[] = new
            Fakultas(
                $row->id,
                $row->name,
                $row->singkatan,
            );
        }
        return $fakultas;
    }
}
