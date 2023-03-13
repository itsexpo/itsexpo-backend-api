<?php

namespace App\Infrastrucutre\Repository;

use App\Core\Domain\Models\Departemen\Departemen;
use App\Core\Domain\Repository\DepartemenRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class SqlDepartemenRepository implements DepartemenRepositoryInterface
{
    /**
     * @param int $fakultas_id
     * @return Departemen[]
     * @throws Exception
     */
    public function getByFakultasId(int $fakultas_id): array
    {
        $row = DB::table('departemen')->where('fakultas_id', '=', $fakultas_id)->get();

        return $this->constructFromRows($row->all());
    }

    public function find(int $id): ?Departemen
    {
        $row = DB::table('departemen')->where('id', $id)->first();
        
        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    public function getAll(): array
    {
        $rows = DB::table('departemen')->get();

        return $this->constructFromRows($rows->all());
    }

    /**
     * @param array $rows
     * @return Departemen[]
     * @throws Exception
     */
    public function constructFromRows(array $rows): array
    {
        $departemen = [];
        foreach ($rows as $row) {
            $departemen[] = new Departemen(
                $row->id,
                $row->fakultas_id,
                $row->name,
            );
        }
        return $departemen;
    }
}
