<?php

namespace App\Infrastrucutre\Repository;

use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\Pembayaran\Pembayaran;
use App\Core\Domain\Models\Pembayaran\PembayaranId;
use App\Core\Domain\Repository\PembayaranRepositoryInterface;

class SqlPembayaranRepository implements PembayaranRepositoryInterface
{
    public function find(PembayaranId $pembayaran_id): ?Pembayaran
    {
        $row = DB::table('pembayaran')->where('id', $pembayaran_id->toString())->first();

        return $this->constructFromRows([$row])[0];
    }

    /**
     * @throws Exception
     */
    private function constructFromRows(array $rows): array
    {
        $pembayaran = [];
        foreach ($rows as $row) {
            $pembayaran[] = new Pembayaran(
                new PembayaranId($row->id),
                $row->list_bank_id,
                $row->list_event_id,
                $row->status_pembayaran_id,
                $row->bukti_pembayaran_url,
                $row->harga
            );
        }
        return $pembayaran;
    }
}
