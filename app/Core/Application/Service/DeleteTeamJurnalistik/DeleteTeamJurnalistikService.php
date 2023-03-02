<?php

namespace App\Core\Application\Service\DeleteTeamJurnalistik;

use App\Exceptions\UserException;
use App\Core\Domain\Models\Jurnalistik\JurnalistikMemberType;
use App\Core\Domain\Repository\JurnalistikTeamRepositoryInterface;
use App\Core\Domain\Repository\JurnalistikMemberRepositoryInterface;
use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikTeamId;

class DeleteTeamJurnalistikService
{
    private JurnalistikTeamRepositoryInterface $jurnalistik_team_repository;
    private JurnalistikMemberRepositoryInterface $jurnalistik_member_repository;

    public function __construct(JurnalistikTeamRepositoryInterface $jurnalistik_team_repository, JurnalistikMemberRepositoryInterface $jurnalistik_member_repository)
    {
        $this->jurnalistik_team_repository = $jurnalistik_team_repository;
        $this->jurnalistik_member_repository = $jurnalistik_member_repository;
    }

    public function execute(DeleteTeamJurnalistikRequest $request)
    {
        $jurnalistik_member = $this->jurnalistik_member_repository->findByUser($request->getAccount()->getUserId());
        if ($jurnalistik_member->getMemberType() != JurnalistikMemberType::KETUA) {
            UserException::throw("hanya ketua yang dapat untuk menghapus", 6006);
        }
        if ($jurnalistik_member->getJurnalistikTeamId() == '') {
            UserException::throw("anda sedang tidak tergabung dalam team manapun", 6007);
        }
        $this->jurnalistik_member_repository->updateTeamId($request->getAccount()->getUserId(), new JurnalistikTeamId(''));
        $this->jurnalistik_team_repository->decrementJumlahAnggota(new JurnalistikTeamId($request->getCodeTeam()));
    }
}
