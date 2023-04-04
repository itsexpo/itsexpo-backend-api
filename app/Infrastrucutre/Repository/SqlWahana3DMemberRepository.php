<?php

namespace App\Infrastrucutre\Repository;

use App\Core\Domain\Models\Wahana3D\Member\Wahana3DMember;
use App\Core\Domain\Models\Wahana3D\Member\Wahana3DMemberId;
use App\Core\Domain\Models\Wahana3D\Team\Wahana3DTeamId;
use App\Core\Domain\Models\Wahana3D\Wahana3DMemberType;
use App\Core\Domain\Repository\Wahana3DMemberRepositoryInterface;
use Illuminate\Support\Facades\DB;

class SqlWahana3DMemberRepository implements Wahana3DMemberRepositoryInterface
{
    public function find(Wahana3DMemberId $id): ?Wahana3DMember
    {
        $row = DB::table('wahana_3d_member')->where('id', $id->toString())->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    public function findByTeamId(Wahana3DTeamId $team_id): ?array
    {
        $row = DB::table('wahana_3d_member')->where('wahana_3d_team_id', '=', $team_id->toString())->get();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    public function findLeadByTeamId(Wahana3DTeamId $wahana_team_id): Wahana3DMember
    {
        $row = DB::table('wahana_3d_member')->where('wahana_3d_team_id', '=', $wahana_team_id->toString())->where('member_type', '=', 'KETUA')->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    public function findAllMember(Wahana3DTeamId $wahana_team_id): array
    {
        $row = DB::table('wahana_3d_member')->where('wahana_3d_team_id', $wahana_team_id->toString())->get();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows($row->all());
    }

    public function persist(Wahana3DMember $member): void
    {
        DB::table('wahana_3d_member')->upsert([
          'id' => $member->getId()->toString(),
          'wahana_3d_team_id' => $member->getTeamId()->toString(),
          'departemen_id' => $member->getDepartemenId(),
          'member_type' => $member->getMemberType()->value,
          'name' => $member->getName(),
          'nrp' => $member->getNrp(),
          'kontak' => $member->getKontak(),
          'ktm_url' => $member->getKtmUrl(),
        ], 'id');
    }

    public function constructFromRows(array $rows): array
    {
        $wahana_3d_member = [];
        foreach ($rows as $row) {
            $wahana_3d_member = new Wahana3DMember(
                new Wahana3DMemberId($row->id),
                new Wahana3DTeamId($row->wahana_3d_team_id),
                Wahana3DMemberType::from($row->member_type),
                $row->departemen_id,
                $row->name,
                $row->nrp,
                $row->kontak,
                $row->ktm_url
            );
        }
        return $wahana_3d_member;
    }
}
