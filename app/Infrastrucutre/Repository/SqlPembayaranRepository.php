<?php

namespace App\Infrastrucutre\Repository;

use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\Pembayaran\Pembayaran;
use App\Core\Domain\Models\Pembayaran\PembayaranId;
use App\Core\Domain\Repository\PembayaranRepositoryInterface;

class SqlPembayaranRepository implements PembayaranRepositoryInterface
{
    public function persist(Pembayaran $pembayaran): void
    {
        DB::table('pembayaran')->upsert([
            'id' => $pembayaran->getId()->toString(),
            'list_bank_id' => $pembayaran->getListBankId(),
            'list_event_id' => $pembayaran->getListEventId(),
            'status_pembayaran_id' => $pembayaran->getStatusPembayaranId(),
            'atas_nama' => $pembayaran->getAtasNama(),
            'bukti_pembayaran_url' => $pembayaran->getBuktiPembayaranUrl(),
            'harga' => $pembayaran->getHarga(),
        ], 'id');
    }

    public function find(PembayaranId $pembayaran_id): ?Pembayaran
    {
        $row = DB::table('pembayaran')->where('id', $pembayaran_id->toString())->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    public function changeStatusPembayaran(PembayaranId $id, int $status_pembayaran_id): void
    {
        $row = DB::table('pembayaran')->where('id', $id->toString());
        
        $row->update(
            ['status_pembayaran_id' => $status_pembayaran_id]
        );
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
                $row->atas_nama,
                $row->bukti_pembayaran_url,
                $row->harga
            );
        }
        return $pembayaran;
    }
}
