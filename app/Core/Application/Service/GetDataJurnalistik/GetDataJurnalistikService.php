<?php

namespace App\Core\Application\Service\GetDataJurnalistik;

use App\Exceptions\UserException;
use App\Core\Domain\Models\UserAccount;
use App\Core\Domain\Repository\JurnalistikMemberRepositoryInterface;
use App\Core\Domain\Repository\JurnalistikTeamRepositoryInterface;
use App\Core\Domain\Models\Jurnalistik\Member\JurnalistikMember;
use App\Core\Domain\Repository\KabupatenRepositoryInterface;
use App\Core\Domain\Repository\ProvinsiRepositoryInterface;
use App\Core\Domain\Repository\PembayaranRepositoryInterface;
use App\Core\Domain\Repository\StatusPembayaranRepositoryInterface;

class GetDataJurnalistikService
{
    private JurnalistikTeamRepositoryInterface $jurnalistik_team_repository;
    private JurnalistikMemberRepositoryInterface $jurnalistik_member_repository;
    private KabupatenRepositoryInterface $kabupaten_repository;
    private ProvinsiRepositoryInterface $provinsi_repository;
    private PembayaranRepositoryInterface $pembayaran_repository;
    private StatusPembayaranRepositoryInterface $status_pembayaran;

    public function __construct(JurnalistikMemberRepositoryInterface $jurnalistik_member_repository, JurnalistikTeamRepositoryInterface $jurnalistik_team_repository, KabupatenRepositoryInterface $kabupaten_repository, ProvinsiRepositoryInterface $provinsi_repository, PembayaranRepositoryInterface $pembayaran_repository, StatusPembayaranRepositoryInterface $status_pembayaran)
    {
        $this->jurnalistik_member_repository = $jurnalistik_member_repository;
        $this->jurnalistik_team_repository = $jurnalistik_team_repository;
        $this->provinsi_repository = $provinsi_repository;
        $this->kabupaten_repository = $kabupaten_repository;
        $this->pembayaran_repository = $pembayaran_repository;
        $this->status_pembayaran = $status_pembayaran;
    }

    public function execute(UserAccount $account): GetDataJurnalistikResponse
    {
        $user_jurnalistik_info = $this->jurnalistik_member_repository->findByUserId($account->getUserId());
        if (!$user_jurnalistik_info) {
            return UserException::throw("Data Tidak Ditemukan", 6060, 400);
        }
        if ($user_jurnalistik_info->getJurnalistikTeamId()->toString() == null) {
            return UserException::throw("User Belum Memiliki Tim", 6060, 400);
        }
        $member_data = $this->jurnalistik_member_repository->findAllMember($user_jurnalistik_info->getJurnalistikTeamId());
        $team_data = $this->jurnalistik_team_repository->find($user_jurnalistik_info->getJurnalistikTeamId());
        $members_array = array_map(function (JurnalistikMember $member) {
            return new MembersResponse($member);
        }, $member_data);

        $user_provinsi = $this->provinsi_repository->find($user_jurnalistik_info->getProvinsiId())->getName();
        $user_kabupaten = $this->kabupaten_repository->find($user_jurnalistik_info->getKabupatenId())->getName();
        $pembayaran = "awaiting payment";
        if ($team_data->getPembayaranId()->toString() != null) {
            $pembayaran = $this->status_pembayaran->find($this->pembayaran_repository->find($team_data->getPembayaranId())->getStatusPembayaranId())->getStatus();
        }
        $response = new GetDataJurnalistikResponse($team_data, $members_array, $user_jurnalistik_info, $user_provinsi, $user_kabupaten, $pembayaran);

        return $response;
    }
}
