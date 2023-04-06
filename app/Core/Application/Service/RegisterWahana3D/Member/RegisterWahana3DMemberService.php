<?php

namespace App\Core\Application\Service\RegisterWahana3D\Member;

use App\Core\Application\ImageUpload\ImageUpload;
use App\Core\Domain\Models\UserAccount;
use App\Core\Domain\Models\NRP;
use App\Core\Domain\Models\UserHasListEvent\UserHasListEvent;
use App\Core\Domain\Models\Wahana3D\Member\Wahana3DMember;
use App\Core\Domain\Models\Wahana3D\Wahana3DMemberType;
use App\Core\Domain\Repository\UserHasListEventRepositoryInterface;
use App\Core\Domain\Repository\Wahana3DMemberRepositoryInterface;
use App\Core\Domain\Repository\Wahana3DTeamRepositoryInterface;
use App\Exceptions\UserException;

class RegisterWahana3DMemberService
{
    private Wahana3DTeamRepositoryInterface $wahana_3d_team_repository;
    private Wahana3DMemberRepositoryInterface $wahana_3d_member_repository;
    private UserHasListEventRepositoryInterface $user_has_list_event_repository;

    /**
     * @param Wahana3DTeamRepositoryInterface $wahana_3d_team_repository
     * @param Wahana3DMemberRepositoryInterface $wahana_3d_member_repository
     * @param UserHasListEventRepositoryInterface $user_has_list_event_repository
     */
    public function __construct(Wahana3DTeamRepositoryInterface $wahana_3d_team_repository, Wahana3DMemberRepositoryInterface $wahana_3d_member_repository, UserHasListEventRepositoryInterface $user_has_list_event_repository)
    {
        $this->wahana_3d_team_repository = $wahana_3d_team_repository;
        $this->wahana_3d_member_repository = $wahana_3d_member_repository;
        $this->user_has_list_event_repository = $user_has_list_event_repository;
    }

    public function execute(array $requests, UserAccount $account)
    {
        $num_members = count($requests) + 1; // Cek ketua

        if ($num_members > 3) {
            UserException::throw("Kategori Wahana 3D Maksimal 3 Anggota", 6002);
        } else {
            $team_id = $this->wahana_3d_team_repository->findByUserId($account->getUserId());
            foreach ($requests as $request) {
                $ktm_url = ImageUpload::create(
                    $request->getKtm(),
                    'wahana_3d/ktm',
                    $account->getUserId()->toString(),
                    'KTM'
                )->upload();

                $nrp = new NRP($request->getNrp());
                $findNrp = $this->wahana_3d_member_repository->findNrp($nrp);

                if ($findNrp) {
                    UserException::throw("NRP Anda Sudah Terdaftar", 6002);
                }

                if ($nrp->getDepartemen() == "" || $nrp->getFakultas() == "") {
                    UserException::throw("NRP Anda Tidak Valid", 6002);
                }

                $member = Wahana3DMember::create(
                    $team_id->getId(),
                    Wahana3DMemberType::MEMBER,
                    $request->getDepartemenId(),
                    $request->getName(),
                    $nrp,
                    $request->getKontak(),
                    $ktm_url
                );
                $this->wahana_3d_member_repository->persist($member);

                $user_has_list_event = UserHasListEvent::create(
                    52,
                    $team_id->getUserId(),
                );

                $this->user_has_list_event_repository->persist($user_has_list_event);
            }
        }
    }
}
