<?php

namespace App\Core\Application\Service\GetWahana2DAdminDetail;

use App\Exceptions\UserException;
use App\Core\Domain\Repository\ListBankRepositoryInterface;
use App\Core\Domain\Repository\PembayaranRepositoryInterface;
use App\Core\Domain\Models\RobotInAction\RobotInActionMemberType;
use App\Core\Domain\Models\RobotInAction\Team\RobotInActionTeamId;
use App\Core\Domain\Models\Wahana2D\Wahana2DId;
use App\Core\Domain\Repository\DepartemenRepositoryInterface;
use App\Core\Domain\Repository\StatusPembayaranRepositoryInterface;
use App\Core\Domain\Repository\RobotInActionMemberRepositoryInterface;
use App\Core\Domain\Repository\Wahana2DRepositoryInterface;

class GetWahana2DAdminDetailService
{
    private Wahana2DRepositoryInterface $wahana_2d_repository;
    private StatusPembayaranRepositoryInterface $status_pembayaran_repository;
    private PembayaranRepositoryInterface $pembayaran_repository;
    private ListBankRepositoryInterface $list_bank_repository;
    private DepartemenRepositoryInterface $departement_repository;

    public function __construct(Wahana2DRepositoryInterface $wahana_2d_repository, StatusPembayaranRepositoryInterface $status_pembayaran_repository, PembayaranRepositoryInterface $pembayaran_repository, ListBankRepositoryInterface $list_bank_repository, DepartemenRepositoryInterface $departement_repository)
    {
        $this->wahana_2d_repository = $wahana_2d_repository;
        $this->status_pembayaran_repository = $status_pembayaran_repository;
        $this->pembayaran_repository = $pembayaran_repository;
        $this->list_bank_repository = $list_bank_repository;
        $this->departement_repository = $departement_repository;
    }

    public function execute(string $id_peserta): GetWahana2DAdminDetailResponse
    {
        $id = new Wahana2DId($id_peserta);
        $peserta = $this->wahana_2d_repository->find($id);
        if (!$peserta) {
            UserException::throw("Id Peseta Tidak ditemukan", 9060);
        }

        $payment_id = $peserta->getPembayaranId();
        $departemen = $this->departement_repository->find($peserta->getDepartemenId());

        if ($payment_id->toString() == null) {
            $payment_status = "AWAITING PAYMENT";

            $payment_obj = new PembayaranObjResponse($payment_status);

            $final = new GetWahana2DAdminDetailResponse($peserta->getName(), $peserta->getKTM(), $departemen->getName(), $peserta->getUploadKaryaUrl(), $peserta->getNrp()->toString(), $peserta->getDeskripsiUrl(), $peserta->getFormKeaslianUrl(), $peserta->getKontak(), $peserta->getStatus(), $payment_obj);
            return $final;
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

            $final = new GetWahana2DAdminDetailResponse($peserta->getName(), $peserta->getKTM(), $departemen->getName(), $peserta->getUploadKaryaUrl(), $peserta->getNrp()->toString(), $peserta->getDeskripsiUrl(), $peserta->getFormKeaslianUrl(), $peserta->getKontak(), $peserta->getStatus(), $payment_obj);

            return $final;
        }
    }
}
