<?php

namespace App\Core\Application\Service\Wahana2DAdmin;

use App\Core\Domain\Models\Wahana2D\Wahana2D;
use App\Core\Domain\Repository\Wahana2DRepositoryInterface;
use App\Core\Domain\Repository\PembayaranRepositoryInterface;
use App\Core\Domain\Repository\StatusPembayaranRepositoryInterface;
use App\Core\Application\Service\Wahana2DAdmin\Wahana2DAdminRequest;
use App\Core\Application\Service\Wahana2DAdmin\Wahana2DAdminResponse;
use App\Core\Application\Service\Wahana2DAdmin\Wahana2DAdminPaginationResponse;


class Wahana2DAdminService
{
    private Wahana2DRepositoryInterface $wahana_2d_repository;
    private PembayaranRepositoryInterface $pembayaran_repository;
    private StatusPembayaranRepositoryInterface $status_pembayaran_repository;

    public function __construct(Wahana2DRepositoryInterface $wahana_2d_repository, PembayaranRepositoryInterface $pembayaran_repository, StatusPembayaranRepositoryInterface $status_pembayaran_repository)
    {
        $this->wahana_2d_repository = $wahana_2d_repository;
        $this->pembayaran_repository = $pembayaran_repository;
        $this->status_pembayaran_repository = $status_pembayaran_repository;
    }

    public function execute(Wahana2DAdminRequest $request)
    {
        $rows = $this->wahana_2d_repository->getAll();

        $totalpendaftar = $this->wahana_2d_repository->getTotalPendaftarCount();
        $pembayaran_revisi = $this->wahana_2d_repository->getPembayaranCount(1);
        $pembayaran_gagal = $this->wahana_2d_repository->getPembayaranCount(2);
        $pembayaran_success = $this->wahana_2d_repository->getPembayaranCount(3);
        $pembayaran_awaiting_verification = $this->wahana_2d_repository->getPembayaranCount(4);
        $pembayaran_awaiting_payment = $this->wahana_2d_repository->getAwaitingPayment();


        if ($request->getFilter()) {
            $rows->where('pembayaran.status_pembayaran_id', $request->getFilter());
        }
        if ($request->getSearch()) {
            $rows->where('wahana_2d.name', 'like', '%' . $request->getSearch() . '%');
        }

        $rows = $rows->paginate($request->getPerPage(), ['wahana_2d.*'], 'Data Management', $request->getPage());

        $data = [];
        foreach ($rows as $row) {
            $data[] = $this->wahana_2d_repository->constructFromRows([$row])[0];
        }

        $data_paginations = [
            "data" => $data,
            "max_page" => ceil($rows->total() / $request->getPerPage())
        ];

        $data_response = array_map(
            function (Wahana2D $peserta) {
                $status_pembayaran = "AWAITING PAYMENT";
                if ($peserta->getPembayaranId()->toString() != null) {
                    $pembayaran_id = $this->pembayaran_repository->find($peserta->getPembayaranId())->getStatusPembayaranId();
                    $status_pembayaran = $this->status_pembayaran_repository->find($pembayaran_id)->getStatus();
                }

                return new Wahana2DAdminResponse(
                    $peserta->getName(),
                    $peserta->getCreatedAt(),
                    $status_pembayaran,
                );
            },
            $data_paginations['data']
        );

        return new Wahana2DAdminPaginationResponse($data_response, $request->getPage(), $data_paginations['max_page'], $totalpendaftar, $pembayaran_revisi, $pembayaran_gagal, $pembayaran_success, $pembayaran_awaiting_verification, $pembayaran_awaiting_payment);
    }
}
