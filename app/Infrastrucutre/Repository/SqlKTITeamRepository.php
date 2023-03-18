<?php

namespace App\Infrastrucutre\Repository;

use App\Core\Domain\Models\KTI\Team\KTITeam;
use App\Core\Domain\Models\KTI\Team\KTITeamId;
use App\Core\Domain\Models\Pembayaran\PembayaranId;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Repository\KTITeamRepositoryInterface;
use Illuminate\Support\Facades\DB;

class SqlKTITeamRepository implements KTITeamRepositoryInterface
{
    public function find(KTITeamId $kti_team_id): ?KTITeam
    {
        $row = DB::table('kti_team')->where('id', $kti_team_id->toString())->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    public function findByUserId(UserId $user_id): ?KTITeam
    {
        $row = DB::table('kti_team')->where('user_id', $user_id->toString())->first();
        
        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    public function persist(KTITeam $team): void
    {
        DB::table('kti_team')->upsert([
          'id' => $team->getId()->toString(),
          'pembayaran_id' => $team->getPembayaranId(),
          'user_id' => $team->getUserId()->toString(),
          'team_name' => $team->getTeamName(),
          'asal_instansi' => $team->getAsalInstansi(),
          'follow_sosmed' => $team->getFollowSosmed(),
          'bukti_repost' => $team->getBuktiRepost(),
          'twibbon' => $team->getTwibbon(),
          'abstrak' => $team->getAbstrak()
        ], 'id');
    }

    public function constructFromRows(array $rows): array
    {
        $kti_team = [];
        foreach ($rows as $row) {
            $kti_team[] = new KTITeam(
                new KTITeamId($row->id),
                new PembayaranId($row->pembayaran_id),
                new UserId($row->user_id),
                $row->team_name,
                $row->asal_instansi,
                $row->follow_sosmed,
                $row->bukti_repost,
                $row->twibbon,
                $row->abstrak,
            );
        }
        return $kti_team;
    }
}
