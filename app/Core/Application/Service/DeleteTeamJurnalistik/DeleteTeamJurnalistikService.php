<?php

namespace App\Core\Application\Service\DeleteTeamJurnalistik;

use App\Exceptions\UserException;
use App\Core\Domain\Models\Jurnalistik\JurnalistikMemberType;
use App\Core\Domain\Models\Jurnalistik\Member\JurnalistikMemberId;
use App\Core\Domain\Repository\JurnalistikTeamRepositoryInterface;
use App\Core\Domain\Repository\JurnalistikMemberRepositoryInterface;
use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikTeamId;
use App\Core\Domain\Models\UserAccount;

class DeleteTeamJurnalistikService
{
    private JurnalistikTeamRepositoryInterface $jurnalistik_team_repository;
    private JurnalistikMemberRepositoryInterface $jurnalistik_member_repository;

    public function __construct(JurnalistikTeamRepositoryInterface $jurnalistik_team_repository, JurnalistikMemberRepositoryInterface $jurnalistik_member_repository)
    {
        $this->jurnalistik_team_repository = $jurnalistik_team_repository;
        $this->jurnalistik_member_repository = $jurnalistik_member_repository;
    }

    public function execute(DeleteTeamJurnalistikRequest $request, UserAccount $account)
    {
        $jurnalistik_member = $this->jurnalistik_member_repository->find(new JurnalistikMemberId($request->getIdPersonal()));
        if (!$jurnalistik_member) {
            UserException::throw("Anda Tidak Terdaftar Menjadi Anggota Team Ini", 6019);
        }

        $executor = $this->jurnalistik_member_repository->findByUser($account->getUserId());

        if ($executor->getMemberType() != JurnalistikMemberType::KETUA) {
            UserException::throw("Hanya Ketua yang Memiliki Akses Untuk Menghapus Data Team", 6006);
        }
        if (!$jurnalistik_member->getJurnalistikTeamId()) {
            UserException::throw("Anda Belum Mempunyai Team", 6007);
        }
        $this->jurnalistik_member_repository->updateTeamId($jurnalistik_member->getId(), new JurnalistikTeamId(null));
        $this->jurnalistik_team_repository->decrementJumlahAnggota($request->getCodeTeam());
    }
}
