<?php

namespace App\Infrastrucutre\Repository;

use App\Core\Domain\Models\Kecamatan\Kecamatan;
use App\Core\Domain\Repository\KecamatanRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class SqlKecamatanRepository implements KecamatanRepositoryInterface
{
    /**
     * @return Kecamatan[]
     * @throws Exceptions
     */
    public function getAll(): array
    {
        $rows = DB::table('kecamatan')->get();
        return $this->constructFromRows($rows->all());
    }

    /**
     * @param int $kabupaten_id
     * @return Kecamatan[]
     * @throws Exception
     */
    public function getByKabupatenId(int $kabupaten_id): array
    {
        $row = DB::table('kecamatan')->where('kabupaten_id', '=', $kabupaten_id)->get();

        return $this->constructFromRows($row->all());
    }

    public function find(int $id): ?Kecamatan
    {
        $row = DB::table('kecamatan')->where('id', $id)->first();
        return $this->constructFromRows([$row])[0];
    }

    /**
     * @param array $rows
     * @return Kecamatan[]
     * @throws Exception
     */
    public function constructFromRows(array $rows): array
    {
        $kecamatan = [];
        foreach ($rows as $row) {
            $kecamatan[] = new Kecamatan(
                $row->id,
                $row->kabupaten_id,
                $row->name,
            );
        }
        return $kecamatan;
    }
}
