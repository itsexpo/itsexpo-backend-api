<?php

namespace App\Infrastrucutre\Repository;

use App\Core\Domain\Models\Desa\Desa;
use App\Core\Domain\Repository\DesaRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class SqlDesaRepository implements DesaRepositoryInterface
{
    /**
     * @throws Exception
     */
    public function getAll(): array
    {
        $rows = DB::table('desa')->get();

        return $this->constructFromRows($rows->all());
    }

    /**
     * @param int $kecamatan_id
     * @return Desa[]
     * @throws Exception
     */
    public function getByKecamatanId(int $kecamatan_id): array
    {
        $row = DB::table('desa')->where('kecamatan_id', '=', $kecamatan_id)->get();

        return $this->constructFromRows($row->all());
    }

    public function find(int $id): ?Desa
    {
        $row = DB::table('desa')->where('id', $id)->first();
        return $this->constructFromRows([$row])[0];
    }

    /**
     * @param array $rows
     * @return Desa[]
     * @throws Exception
     */
    public function constructFromRows(array $rows): array
    {
        $desa = [];
        foreach ($rows as $row) {
            $desa[] = new Desa(
                $row->id,
                $row->kecamatan_id,
                $row->name,
            );
        }
        return $desa;
    }
}
