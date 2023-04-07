<?php

namespace App\Infrastrucutre\Repository;

use App\Core\Domain\Models\KTI\Team\KTITeam;
use App\Core\Domain\Models\KTI\Team\KTITeamId;
use App\Core\Domain\Models\Pembayaran\PembayaranId;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Repository\KTITeamRepositoryInterface;
use Illuminate\Database\Query\Builder;
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

        $pembayaran_id = ($team->getPembayaranId() == null) ? $team->getPembayaranId() : $team->getPembayaranId()->toString();

        DB::table('kti_team')->upsert([
          'id' => $team->getId()->toString(),
          'pembayaran_id' => $pembayaran_id,
          'user_id' => $team->getUserId()->toString(),
          'team_name' => $team->getTeamName(),
          'team_code' => $team->getTeamCode(),
          'asal_instansi' => $team->getAsalInstansi(),
          'follow_sosmed' => $team->getFollowSosmed(),
          'bukti_repost' => $team->getBuktiRepost(),
          'twibbon' => $team->getTwibbon(),
          'lolos_paper' => $team->isLolosPaper(),
          'full_paper' => $team->getFullPaper(),
          'abstrak' => $team->getAbstrak()
        ], 'id');
    }

    public function getCreatedAt(KTITeamId $kti_team_id): ?string
    {
        $row = DB::table('kti_team')->where('id', $kti_team_id->toString())->first();

        if (!$row) {
            return null;
        }

        return $row->created_at;
    }

    public function getTeams(): Builder
    {
        $rows = DB::table('kti_team')->leftJoin('pembayaran', 'kti_team.pembayaran_id', '=', 'pembayaran.id')->leftJoin('status_pembayaran', 'pembayaran.status_pembayaran_id', '=', 'status_pembayaran.id')->leftJoin('kti_member', 'kti_team.id', '=', 'kti_member.kti_team_id')->where('kti_member.member_type', 'KETUA');

        if (!$rows) {
            return null;
        }

        return $rows;
    }

    public function getTotalTimCount(): int
    {
        $rows = DB::table('kti_team')->count();

        if (!$rows) {
            return 0;
        }

        return $rows;
    }

    public function getPembayaranRevisiCount(int $status_pembayaran): int
    {
        $rows = DB::table('kti_team')->leftJoin('pembayaran', 'kti_team.pembayaran_id', '=', 'pembayaran.id')->where('pembayaran.status_pembayaran_id', $status_pembayaran)->count();

        if (!$rows) {
            return 0;
        }

        return $rows;
    }

    public function getPembayaranGagalCount(int $status_pembayaran): int
    {
        $rows = DB::table('kti_team')->leftJoin('pembayaran', 'kti_team.pembayaran_id', '=', 'pembayaran.id')->where('pembayaran.status_pembayaran_id', $status_pembayaran)->count();

        if (!$rows) {
            return 0;
        }

        return $rows;
    }

    public function getPembayaranSuccessCount(int $status_pembayaran): int
    {
        $rows = DB::table('kti_team')->leftJoin('pembayaran', 'kti_team.pembayaran_id', '=', 'pembayaran.id')->where('pembayaran.status_pembayaran_id', $status_pembayaran)->count();

        if (!$rows) {
            return 0;
        }

        return $rows;
    }

    public function getAwaitingVerificationCount(int $status_pembayaran): int
    {
        $rows = DB::table('kti_team')->leftJoin('pembayaran', 'kti_team.pembayaran_id', '=', 'pembayaran.id')->where('pembayaran.status_pembayaran_id', $status_pembayaran)->count();

        if (!$rows) {
            return 0;
        }

        return $rows;
    }

    public function getAwaitingPaymentCount(int $status_pembayaran): int
    {
        $rows = DB::table('kti_team')->leftJoin('pembayaran', 'kti_team.pembayaran_id', '=', 'pembayaran.id')->where('pembayaran.status_pembayaran_id', $status_pembayaran)->count();

        if (!$rows) {
            return 0;
        }

        return $rows;
    }

    public function getFilter(Builder $kti_team, ?array $filter): void
    {
        $kti_team->where('pembayaran.status_pembayaran_id', $filter);
    }

    public function getSearch(Builder $kti_team, ?string $search): void
    {
        $kti_team->where('kti_team.team_name', 'like', '%' . $search . '%')->orWhere('kti_member.name', 'like', '%' . $search . '%');
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
                $row->team_code,
                $row->asal_instansi,
                $row->follow_sosmed,
                $row->bukti_repost,
                $row->twibbon,
                $row->abstrak,
                $row->lolos_paper,
                $row->full_paper,
                $row->created_at,
            );
        }
        return $kti_team;
    }

    public function updatePembayaran(KTITeamId $kti_team_id, PembayaranId $pembayaran_id): void
    {
        $kti_team = DB::table('kti_team')->where('id', $kti_team_id->toString());
        if (!$kti_team->first()) {
            return;
        }
        $kti_team->update(
            ['pembayaran_id' => $pembayaran_id->toString()]
        );
    }

    public function countAllTeams(): int
    {
        $count = DB::table('jurnalistik_team')->count();
        return $count;
    }

    public function findByPembayaranId(PembayaranId $pembayaran_id): KTITeam
    {
        $row = DB::table('kti_team')->where('pembayaran_id', $pembayaran_id->toString())->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }
}
