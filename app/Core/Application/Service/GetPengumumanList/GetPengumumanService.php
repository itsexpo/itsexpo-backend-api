<?php

namespace App\Core\Application\Service\GetPengumumanList;

use App\Exceptions\UserException;
use App\Core\Domain\Models\Pengumuman\Pengumuman;
use App\Core\Application\Service\PaginationResponse;
use App\Core\Domain\Repository\PengumumanRepositoryInterface;

class GetPengumumanService
{
    private PengumumanRepositoryInterface $pengumuman_repository;

    public function __construct(PengumumanRepositoryInterface $pengumuman_repository)
    {
        $this->pengumuman_repository = $pengumuman_repository;
    }

    public function execute(GetPengumumanRequest $request)
    {
        if ($request->getPage() && $request->getPerPage()) {
            if ($request->getEventId()) {
                $pengumuman_pagination = $this->pengumuman_repository->getByEventIdWithPagination($request->getPage(), $request->getPerPage(), $request->getEventId());
            } elseif ($request->getPengumumanId()) {
                $pengumuman_pagination = $this->pengumuman_repository->getById($request->getPengumumanId());
                if (!$pengumuman_pagination) {
                    UserException::throw("Pengumuman tidak ditemukan", 1231, 404);
                }
                return new GetPengumumanResponse(
                    $pengumuman_pagination
                );
            } else {
                $pengumuman_pagination = $this->pengumuman_repository->getWithPagination($request->getPage(), $request->getPerPage());
            }
            $max_page = $pengumuman_pagination['max_page'];
            $pengumuman_response = array_map(function (Pengumuman $pengumuman) {
                return new GetPengumumanResponse(
                    $pengumuman
                    //yang dibutuhin untuk ditampilkan apa aja
                );
            }, $pengumuman_pagination['data']);

            return new PaginationResponse($pengumuman_response, $request->getPage(), $max_page);
        } else {
            if ($request->getEventId()) {
                $allPengumuman = $this->pengumuman_repository->getByEventId($request->getEventId());
            } elseif ($request->getPengumumanId()) {
                $pengumuman_pagination = $this->pengumuman_repository->getById($request->getPengumumanId());
                if (!$pengumuman_pagination) {
                    UserException::throw("Pengumuman tidak ditemukan", 1231, 404);
                }
                return new GetPengumumanResponse(
                    $pengumuman_pagination
                );
            } else {
                $allPengumuman = $this->pengumuman_repository->getAll();
            }
            return array_map(function (Pengumuman $pengumuman) {
                return new GetPengumumanResponse(
                    $pengumuman
                    //yang dibutuhin untuk ditampilkan apa aja
                );
            }, $allPengumuman);
        }
    }
}
