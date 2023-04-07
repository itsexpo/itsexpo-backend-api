<?php

namespace App\Infrastrucutre\Repository;

use App\Core\Domain\Models\NRP;
use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\Wahana2D\Wahana2D;
use App\Core\Domain\Models\Wahana2D\Wahana2DId;
use App\Core\Domain\Models\Pembayaran\PembayaranId;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Repository\Wahana2DRepositoryInterface;

class SqlWahana2DRepository implements Wahana2DRepositoryInterface
{
    public function find(Wahana2DId $kti_member_id): ?Wahana2D
    {
        $row = DB::table('kti_member')->where('id', $kti_member_id->toString())->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    public function findByName(string $name): ?Wahana2D
    {
        $row = DB::table('wahana_2d')->where('name', '=', $name)->first();
        
        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    public function findByUserId(UserId $user_id): ?Wahana2D
    {
        $row = DB::table('wahana_2d')->where('user_id', $user_id->toString())->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    public function findByNrp(NRP $nrp): bool
    {
        $row = DB::table('wahana_2d')->where('nrp', '=', $nrp->toString())->first();
        print_r($row);

        if (!$row) {
            return false;
        }
        
        return true;
    }

    public function persist(Wahana2D $member): void
    {
        DB::table('wahana_2d')->upsert([
            'id' => $member->getId()->toString(),
            'pembayaran_id' => $member->getPembayaranId()->toString(),
            'departemen_id' => $member->getDepartemenId(),
            'name' => $member->getName(),
            'nrp' => $member->getNrp()->toString(),
            'kontak' => $member->getKontak(),
            'status' => $member->getStatus(),
            'ktm_url' => $member->getKTM()
        ], 'id');
    }

    public function constructFromRows(array $rows): array
    {
        $wahana_2d = [];
        foreach ($rows as $row) {
            $wahana_2d[] = new Wahana2D(
                new Wahana2DId($row->id),
                new PembayaranId($row->pembayaran_id),
                $row->departemen_id,
                $row->name,
                $row->nrp,
                $row->kontak,
                $row->status,
                $row->ktm_url,
                $row->created_at
            );
        }
        return $wahana_2d;
    }
}
