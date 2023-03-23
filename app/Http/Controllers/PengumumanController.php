<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Core\Application\Service\AddPengumuman\AddPengumumanRequest;
use App\Core\Application\Service\AddPengumuman\AddPengumumanService;
use App\Core\Application\Service\GetPengumumanList\GetPengumumanRequest;
use App\Core\Application\Service\GetPengumumanList\GetPengumumanService;
use App\Core\Application\Service\DeletePengumuman\DeletePengumumanRequest;
use App\Core\Application\Service\DeletePengumuman\DeletePengumumanService;
use App\Core\Application\Service\UpdatePengumuman\UpdatePengumumanRequest;
use App\Core\Application\Service\UpdatePengumuman\UpdatePengumumanService;

class PengumumanController extends Controller
{
    public function add(Request $request, AddPengumumanService $service): JsonResponse
    {
        DB::beginTransaction();

        $request->validate([
            'event_id' => 'required|integer|exists:list_event,id',
            'title' => 'required',
            'description' => 'required'
        ]);

        $input = new AddPengumumanRequest(
            $request->input('event_id'),
            $request->input('title'),
            $request->input('description')
        );

        try {
            $service->execute($input);
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        DB::commit();
        return $this->success("Pengumuman Berhasil Ditambahkan");
    }

    public function get(Request $request, GetPengumumanService $service): JsonResponse
    {
        $request->validate([
            'event_id' => 'nullable|integer|exists:list_event,id',
            'id' => 'nullable'
        ]);

        $input = new GetPengumumanRequest(
            $request->query('event_id'),
            $request->query('id')
        );

        $response = $service->execute($input);

        return $this->successWithData($response, "Berhasil Mendapatkan Pengumuman");
    }

    public function update(Request $request, UpdatePengumumanService $service)
    {
        DB::beginTransaction();

        $request->validate([
            'event_id' => 'required|integer|exists:list_event,id',
            'title' => 'required',
            'description' => 'required'
        ]);


        $input = new UpdatePengumumanRequest(
            $request->input('event_id'),
            $request->input('title'),
            $request->input('description'),
            $request->input('id')
        );

        try {
            $service->execute($input);
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->success("Pengumuman berhasil diupdate");
    }

    public function delete(Request $request, DeletePengumumanService $service)
    {
        DB::beginTransaction();

        $input = new DeletePengumumanRequest($request->query('id'));

        try {
            $service->execute($input);
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->success("Pengumuman berhasil dihapus");
    }
}
