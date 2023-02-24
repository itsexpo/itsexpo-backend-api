<?php

namespace App\Infrastrucutre\Repository;

use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\StatusPembayaran\StatusPembayaran;
use App\Core\Domain\Repository\StatusPembayaranRepositoryInterface;

class SqlStatusPembayaranRepository implements StatusPembayaranRepositoryInterface
{
    public function find(int $status_pembayaran_id): ?StatusPembayaran
    {
        $row = DB::table('status_pembayaran')->where('id', $status_pembayaran_id)->first();

        return $this->constructFromRows([$row])[0];
    }

    /**
     * @throws Exception
     */
    private function constructFromRows(array $rows): array
    {
        $status_pembayaran = [];
        foreach ($rows as $row) {
            $status_pembayaran[] = new StatusPembayaran(
                $row->id,
                $row->status,
            );
        }
        return $status_pembayaran;
    }
}
