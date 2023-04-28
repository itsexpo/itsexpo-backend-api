<?php

namespace App\Infrastrucutre\Repository;

use App\Core\Domain\Models\Pembayaran\PembayaranId;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Models\Wahana3D\Team\Wahana3DTeamId;
use App\Core\Domain\Models\Wahana3D\Team\Wahana3DTeam;
use App\Core\Domain\Repository\Wahana3DTeamRepositoryInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class SqlWahana3DTeamRepository implements Wahana3DTeamRepositoryInterface
{
    public function find(Wahana3DTeamId $id): ?Wahana3DTeam
    {
        $row = DB::table('wahana_3d_team')->where('id', $id->toString())->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    public function findByPembayaranId(PembayaranId $pembayaran_id): ?Wahana3DTeam
    {
        $row = DB::table('wahana_3d_team')->where('pembayaran_id', $pembayaran_id->toString())->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    public function findByUserId(UserId $user_id): ?Wahana3DTeam
    {
        $row = DB::table('wahana_3d_team')->where('user_id', $user_id->toString())->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    public function getCreatedAt(Wahana3DTeamId $wahana_3d_team_id): ?string
    {
        $row = DB::table('wahana_3d_team')->where('id', $wahana_3d_team_id->toString())->first();

        if (!$row) {
            return "";
        }

        return $row->created_at;
    }

    public function countAllTeams(): int
    {
        return DB::table('wahana_3d_team')->count();
    }

    public function getTeams(): Builder
    {
        $rows = DB::table('wahana_3d_team')->leftJoin('pembayaran', 'wahana_3d_team.pembayaran_id', '=', 'pembayaran.id')->leftJoin('status_pembayaran', 'pembayaran.status_pembayaran_id', '=', 'status_pembayaran.id')->leftJoin('wahana_3d_member', 'wahana_3d_team.id', '=', 'wahana_3d_member.wahana_3d_team_id')->where('wahana_3d_member.member_type', 'KETUA')->orderBy('wahana_3d_team.created_at', 'desc');

        if (!$rows) {
            return null;
        }

        return $rows;
    }

    public function getTotalTimCount(): int
    {
        $rows = DB::table('wahana_3d_team')->count();

        if (!$rows) {
            return 0;
        }

        return $rows;
    }

    public function getPembayaranCount(int $status_pembayaran): int
    {
        $rows = DB::table('wahana_3d_team')->leftJoin('pembayaran', 'wahana_3d_team.pembayaran_id', '=', 'pembayaran.id')->where('pembayaran.status_pembayaran_id', $status_pembayaran)->count();

        if (!$rows) {
            return 0;
        }

        return $rows;
    }

    public function getAwaitingPaymentCount(): int
    {
        $rows = DB::table('wahana_3d_team')->leftJoin('pembayaran', 'wahana_3d_team.pembayaran_id', '=', 'pembayaran.id')->where('pembayaran.status_pembayaran_id', null)->count();

        if (!$rows) {
            return 0;
        }

        return $rows;
    }

    public function getFilter(Builder $wahana_team, ?array $filter): void
    {
        $wahana_team->where('pembayaran.status_pembayaran_id', $filter)->orderBy('wahana_3d_team.created_at', 'desc');
    }

    public function getSearch(Builder $wahana_team, ?string $search): void
    {
        $wahana_team->where('wahana_3d_team.team_name', 'like', '%' . $search . '%')->orWhere('wahana_3d_member.name', 'like', '%' . $search . '%')->orderBy('wahana_3d_team.created_at', 'desc');
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

    public function constructFromRows(array $rows): array
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
