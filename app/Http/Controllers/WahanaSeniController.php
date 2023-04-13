<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Core\Application\Service\RegisterWahana2D\RegisterWahana2DRequest;
use App\Core\Application\Service\RegisterWahana2D\RegisterWahana2DService;
use App\Core\Application\Service\GetUserWahanaSeni\GetUserWahanaSeniService;
use App\Core\Application\Service\UploadBerkasWahana\UploadBerkasWahanaRequest;
use App\Core\Application\Service\UploadBerkasWahana\UploadBerkasWahana2DService;
use App\Core\Application\Service\UploadBerkasWahana\UploadBerkasWahana3DService;
use App\Core\Application\Service\RegisterWahana3D\Ketua\RegisterWahana3DKetuaRequest;
use App\Core\Application\Service\RegisterWahana3D\Ketua\RegisterWahana3DKetuaService;
use App\Core\Application\Service\RegisterWahana3D\Member\RegisterWahana3DMemberRequest;
use App\Core\Application\Service\RegisterWahana3D\Member\RegisterWahana3DMemberService;

class WahanaSeniController extends Controller
{
    public function register2D(Request $request, RegisterWahana2DService $service)
    {
        $request->validate([
            'name' => 'required|string',
            'nrp' => 'required|string',
            'kontak' => 'required|string',
        ]);

        $input = new RegisterWahana2DRequest(
            $request->input('name'),
            $request->input('nrp'),
            $request->input('departemen_id'),
            $request->input('kontak'),
            $request->input('bank_id'),
            $request->input('atas_nama'),
            $request->file('ktm'),
            $request->file('bukti_bayar')
        );

        DB::beginTransaction();
        try {
            $service->execute($input, $request->get('account'));
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();

        return $this->success("Berhasil Mendaftarkan ke Wahana 2D");
    }

    public function register3D(Request $request, RegisterWahana3DKetuaService $wahana_3d_ketua, RegisterWahana3DMemberService $wahana_3d_member)
    {
        $request->validate([
            'team_name' => 'required|string',
            'deskripsi_karya' => 'required|string'
        ]);

        $input_ketua = new RegisterWahana3DKetuaRequest(
            $request->input('team_name'),
            $request->input('name'),
            $request->input('nrp'),
            $request->input('kontak'),
            $request->input('departemen_id'),
            $request->input('deskripsi_karya'),
            $request->input('bank_id'),
            $request->input('atas_nama'),
            $request->file('ktm'),
            $request->file('bukti_bayar')
        );
        $input_member = [];

        if ($request->has(['mahasiswa'])) {
            $input_member = array_map(function (array $member, array $file) {
                return new RegisterWahana3DMemberRequest(
                    $member['departemen_id'],
                    $member['name'],
                    $member['nrp'],
                    $member['kontak'],
                    $file['ktm']
                );
            }, $request->input('mahasiswa'), $request->file('mahasiswa'));
        }

        DB::beginTransaction();
        try {
            $wahana_3d_ketua->execute($input_ketua, $request->get('account'));
            $wahana_3d_member->execute($input_member, $request->get('account'));
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->success("Berhasil Membuat Tim");
    }

    public function getDetail(Request $request, GetUserWahanaSeniService $service)
    {
        $response = $service->execute($request->get('account'));
        return $this->successWithData($response, "Succes getting wahana seni");
    }

    public function uploadBerkas2D(Request $request, UploadBerkasWahana2DService $service)
    {
        $input = new UploadBerkasWahanaRequest(
            $request->file('upload_karya'),
            $request->file('deskripsi'),
            $request->file('form_keaslian'),
        );

        DB::beginTransaction();
        try {
            $service->execute($input, $request->get('account'));
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->success("Berhasil Upload File Berkas");
    }

    public function uploadBerkas3D(Request $request, UploadBerkasWahana3DService $service)
    {
        $input = new UploadBerkasWahanaRequest(
            $request->file('upload_karya'),
            $request->file('deskripsi'),
            $request->file('form_keaslian'),
        );

        DB::beginTransaction();
        try {
            $service->execute($input, $request->get('account'));
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->success("Berhasil Upload File Berkas");
    }
}
