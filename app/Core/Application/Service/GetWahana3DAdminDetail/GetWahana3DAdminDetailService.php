<?php

namespace App\Core\Application\Service\GetWahana3DAdminDetail;

use App\Core\Domain\Models\Wahana3D\Team\Wahana3DTeamId;
use App\Core\Domain\Repository\ListBankRepositoryInterface;
use App\Core\Domain\Repository\PembayaranRepositoryInterface;
use App\Core\Domain\Repository\StatusPembayaranRepositoryInterface;
use App\Core\Domain\Repository\Wahana3DMemberRepositoryInterface;
use App\Core\Domain\Repository\Wahana3DTeamRepositoryInterface;
use App\Exceptions\UserException;

class GetWahana3DAdminDetailService
{
    private Wahana3DTeamRepositoryInterface $wahana_3d_team_repository;
    private Wahana3DMemberRepositoryInterface $wahana_3d_member_repository;
    private StatusPembayaranRepositoryInterface $status_pembayaran_repository;
    private PembayaranRepositoryInterface $pembayaran_repository;
    private ListBankRepositoryInterface $list_bank_repository;

    /**
     * @param Wahana3DTeamRepositoryInterface $wahana_3d_team_repository,
     * @param Wahana3DMemberRepositoryInterface $wahana_3d_member_repository,
     * @param StatusPembayaranRepositoryInterface $status_pembayaran_repository,
     * @param PembayaranRepositoryInterface $pembayaran_repository,
     * @param ListBankRepositoryInterface $list_bank_repository
     */
    public function __construct(
        Wahana3DTeamRepositoryInterface $wahana_3d_team_repository,
        Wahana3DMemberRepositoryInterface $wahana_3d_member_repository,
        StatusPembayaranRepositoryInterface $status_pembayaran_repository,
        PembayaranRepositoryInterface $pembayaran_repository,
        ListBankRepositoryInterface $list_bank_repository
    ) {
        $this->wahana_3d_team_repository = $wahana_3d_team_repository;
        $this->wahana_3d_member_repository = $wahana_3d_member_repository;
        $this->status_pembayaran_repository = $status_pembayaran_repository;
        $this->pembayaran_repository = $pembayaran_repository;
        $this->list_bank_repository = $list_bank_repository;
    }

    public function execute(string $team_id): GetWahana3DAdminDetailResponse
    {
        $id = new Wahana3DTeamId($team_id);
        $team = $this->wahana_3d_team_repository->find($id);
        if (!$team) {
            UserException::throw("Wahana 3D Team Tidak Ditemukan", 3001, 404);
        }

        $members = $this->wahana_3d_member_repository->findAllMember($id);

        $member_array = [];
        foreach ($members as $member) {
            $nama = $member->getName();
            $ketua = $member->getMemberType()->value;
            $is_ketua = false;
            if ($ketua == "KETUA") {
                $is_ketua = true;
            }
            
            $memb = new GetWahana3DAdminDetailTeamMemberResponse($nama, $is_ketua, $member->getKtmUrl());
            array_push($member_array, $memb);
        }

        $payment_id = $team->getPembayaranId();

        if ($payment_id->toString() == null) {
            $payment_status = "AWAITING PAYMENT";

            $payment_obj = new PembayaranObjResponse($payment_status);
        } else {
            $payment = $this->pembayaran_repository->find($payment_id);

            $payment_status = $this->status_pembayaran_repository->find($payment->getStatusPembayaranId())->getStatus();

            $payment_image_url = $payment->getBuktiPembayaranUrl();
            $payment_atas_nama = $payment->getAtasNama();
            if ($payment->getStatusPembayaranId() == 5) {
                $payment_bank = null;
            } else {
                $payment_bank = $this->list_bank_repository->find($payment->getListBankId())->getName();
            }
            $payment_harga = $payment->getHarga();

            $payment_obj = new PembayaranObjResponse($payment_status, $payment_id->toString(), $payment_image_url, $payment_atas_nama, $payment_bank, $payment_harga);
        }

        $final = new GetWahana3DAdminDetailResponse(
            $team->getTeamName(),
            $team->getTeamCode(),
            $payment_obj,
            $member_array
        );

        return $final;
    }
}
