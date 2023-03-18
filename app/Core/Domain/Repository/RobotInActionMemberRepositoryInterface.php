<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Models\RobotInAction\Member\RobotInActionMember;
use App\Core\Domain\Models\RobotInAction\Member\RobotInActionMemberId;
use App\Core\Domain\Models\RobotInAction\Team\RobotInActionTeamId;

interface RobotInActionMemberRepositoryInterface
{
    public function find(RobotInActionMemberId $id): ?RobotInActionMember;

    public function findByUserId(UserId $user_id): ?RobotInActionMember;

    public function findAllMember(RobotInActionTeamId $team_id): array;

    public function persist(RobotInActionMember $member): void;

    public function updateTeamId(RobotInActionMemberId $personal_id, RobotInActionTeamId $team_id): void;

    public function findKetua(RobotInActionTeamId $team_id): ?RobotInActionMember;
}
