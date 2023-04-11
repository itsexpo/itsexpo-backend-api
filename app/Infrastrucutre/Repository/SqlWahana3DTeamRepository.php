<?php

namespace App\Infrastrucutre\Repository;

use App\Core\Domain\Models\Pembayaran\PembayaranId;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Models\Wahana3D\Team\Wahana3DTeamId;
use App\Core\Domain\Models\Wahana3D\Team\Wahana3DTeam;
use App\Core\Domain\Repository\Wahana3DTeamRepositoryInterface;
use Illuminate\Support\Facades\DB;

class SqlWahana3DTeamRepository implements Wahana3DTeamRepositoryInterface
{
    public function find(Wahana3DTeamId $id): ?Wahana3DTeam
    {
        $row = DB::table('wahana_3d_team')->where('id', $id->toString())->first();

        if (!$row) {
            return null;
        }

        return $this->constrctFromRows([$row])[0];
    }

    public function findByUserId(UserId $user_id): ?Wahana3DTeam
    {
        $row = DB::table('wahana_3d_team')->where('user_id', $user_id->toString())->first();

        if (!$row) {
            return null;
        }

        return $this->constrctFromRows([$row])[0];
    }

    public function countAllTeams(): int
    {
        return DB::table('wahana_3d_team')->count();
    }

    public function persist(Wahana3DTeam $team): void
    {
        DB::table('wahana_3d_team')->upsert([
          'id' => $team->getId()->toString(),
          'pembayaran_id' => $team->getPembayaranId()->toString(),
          'user_id' => $team->getUserId()->toString(),
          'team_name' => $team->getTeamName(),
          'team_code' => $team->getTeamCode(),
          'deskripsi_karya' => $team->getDeskripsiKarya(),
          'upload_karya_url' => $team->getUploadKaryaUrl(),
          'deskripsi_url' => $team->getDeskripsiUrl(),
          'form_keaslian_url' => $team->getFormKeaslianUrl(),
        ], 'id');
    }

    public function constrctFromRows(array $rows): array
    {
        $wahana_team = [];
        foreach ($rows as $row) {
            $wahana_team[] = new Wahana3DTeam(
                new Wahana3DTeamId($row->id),
                new PembayaranId($row->pembayaran_id),
                new UserId($row->user_id),
                $row->team_name,
                $row->team_code,
                $row->deskripsi_karya,
                $row->upload_karya_url,
                $row->deskripsi_url,
                $row->form_keaslian_url,
                $row->created_at,
            );
        }
        return $wahana_team;
    }
}
