<?php

namespace App\Infrastrucutre\Repository;

use App\Core\Domain\Models\RobotInAction\RobotInActionMemberType;
use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\RobotInAction\Member\RobotInActionMember;
use App\Core\Domain\Models\RobotInAction\Member\RobotInActionMemberId;
use App\Core\Domain\Models\RobotInAction\Team\RobotInActionTeamId;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Repository\RobotInActionMemberRepositoryInterface;

class SqlRobotInActionMemberRepository implements RobotInActionMemberRepositoryInterface
{
    public function find(RobotInActionMemberId $robot_in_action_member_id): ?RobotInActionMember
    {
        $row = DB::table('robot_in_action_member')->where('id', $robot_in_action_member_id->toString())->first();
        if (!$row) {
            return null;
        }
        return $this->constructFromRows([$row])[0];
    }


    public function updateTeamId(RobotInActionMemberId $personal_id, RobotInActionTeamId $team_id): void
    {
        DB::table('robot_in_action_member')->where('id', $personal_id->toString())->update([
            'robot_in_action_team_id' => $team_id->toString(),
        ]);
    }

    public function findByUserId(UserId $user_id): ?RobotInActionMember
    {
        $row = DB::table('robot_in_action_member')->where('user_id', $user_id->toString())->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    public function findKetua(RobotInActionTeamId $team_id): ?RobotInActionMember
    {
        $row = DB::table('robot_in_action_member')->where('robot_in_action_team_id', $team_id->toString())->where('member_type', 'KETUA')->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    public function findAllMember(RobotInActionTeamId $robot_in_action_team_id): array
    {
        $row = DB::table('robot_in_action_member')->where('robot_in_action_team_id', $robot_in_action_team_id->toString())->get();
        if (!$row) {
            return null;
        }
        return $this->constructFromRows($row->all());
    }

    /**
     * @throws Exception
     */
    private function constructFromRows(array $rows): array
    {
        $robot_in_action_member = [];
        foreach ($rows as $row) {
            $robot_in_action_member[] = new RobotInActionMember(
                new RobotInActionMemberId($row->id),
                new RobotInActionTeamId($row->robot_in_action_team_id),
                new UserId($row->user_id),
                $row->name,
                $row->no_telp,
                RobotInActionMemberType::from($row->member_type),
                $row->asal_sekolah,
                $row->id_card_url,
                $row->follow_sosmed_url,
                $row->share_poster_url,
            );
        }
        return $robot_in_action_member;
    }

    public function persist(RobotInActionMember $member): void
    {
        DB::table('robot_in_action_member')->upsert(
            [
                'id' => $member->getId()->toString(),
                'robot_in_action_team_id' => $member->getRobotInActionTeamId() ? $member->getRobotInActionTeamId()->toString() : null,
                'user_id' => $member->getUserId()->toString(),
                'name' => $member->getName(),
                'no_telp' => $member->getNoTelp(),
                'member_type' => $member->getMemberType()->value,
                'asal_sekolah' => $member->getAsalSekolah(),
                'id_card_url' => $member->getIdCardUrl(),
                'follow_sosmed_url' => $member->getFollowSosmedUrl(),
                'share_poster_url' => $member->getSharePosterUrl(),
            ],
            'id'
        );
    }
}
