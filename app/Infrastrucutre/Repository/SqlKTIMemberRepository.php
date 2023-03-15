<?php

namespace App\Infrastrucutre\Repository;

use App\Core\Domain\Models\KTI\KTIMemberType;
use App\Core\Domain\Models\KTI\Member\KTIMember;
use App\Core\Domain\Models\KTI\Member\KTIMemberId;
use App\Core\Domain\Models\KTI\Team\KTITeamId;
use App\Core\Domain\Repository\KTIMemberRepositoryInterface;
use Illuminate\Support\Facades\DB;

class SqlKTIMemberRepository implements KTIMemberRepositoryInterface
{
    public function find(KTIMemberId $kti_member_id): ?KTIMember
    {
        $row = DB::table('kti_member')->where('id', $kti_member_id->toString())->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    public function persist(KTIMember $member): void
    {
        DB::table('kti_member')->upsert([
          'id' => $member->getId()->toString(),
          'kti_team_id' => $member->getTeamId()->toString(),
          'name' => $member->getName(),
          'no_telp' => $member->getNoTelp(),
          'member_type' => $member->getMemberType()->value
        ], 'id');
    }

    public function constructFromRows(array $rows): array
    {
        $kti_member = [];
        foreach ($rows as $row) {
            $kti_member[] = new KTIMember(
                new KTIMemberId($row->id),
                new KTITeamId($row->kti_team_id),
                $row->name,
                $row->no_telp,
                KTIMemberType::from($row->member_type)
            );
        }
        return $kti_member;
    }
}
