<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\Application\Service\KTIAdmin\KTIAdminRequest;
use App\Core\Application\Service\KTIAdmin\KTIAdminService;
use App\Core\Application\Service\KTIAdminConfirm\KTIAdminConfirmRequest;
use App\Core\Application\Service\KTIAdminConfirm\KTIAdminConfirmService;
use App\Core\Application\Service\GetKtiAdminDetail\GetKtiAdminDetailService;
use App\Core\Application\Service\KTIAdminPass\KTIAdminPassRequest;
use App\Core\Application\Service\KTIAdminPass\KTIAdminPassService;

class KTIAdminController extends Controller
{
    public function getTeam(Request $request, KTIAdminService $service)
    {
        $request->validate([
            'per_page' => 'numeric',
            'page' => 'numeric',
            'filter' => ['sometimes', function ($attr, $val, $fail) {
                if (!is_array($val)) {
                    $fail($attr . ' must be an array of numbers');
                }
                if (is_array($val)) {
                    foreach ($val as $number) {
                        if (!is_numeric($number)) {
                            $fail($attr . ' must be an array of numbers');
                        }
                    }
                }
            }],
            'search' => 'string'
        ]);

        $input = new KTIAdminRequest(
            $request->input('per_page'),
            $request->input('page'),
            $request->input('filter'),
            $request->input('search')
        );

        $response = $service->execute($input);
        return $this->successWithData($response, "Success Get KTI Team Data");
    }

    public function getDetail(Request $request, GetKtiAdminDetailService $service)
    {
        $id = $request->route('team_id');
        $response = $service->execute($id);
        return $this->successWithData($response, "Success getting KTI team detail");
    }

    public function confirmTeam(Request $request, KTIAdminConfirmService $service)
    {
        $request->validate([
            'pembayaran_id' => 'required',
            'status_pembayaran_id' => 'required'
        ]);

        $input = new KTIAdminConfirmRequest(
            $request->input('pembayaran_id'),
            $request->input('status_pembayaran_id')
        );

        $service->execute($input);
        return $this->success("Berhasil Mengubah Status Pembayaran");
    }

    public function passTeam(Request $request, KTIAdminPassService $service)
    {
        $id = $request->route('team_id');

        $request->validate([
            'lolos_paper' => 'required',
        ]);

        $input = new KTIAdminPassRequest(
            $id,
            $request->input('lolos_paper'),
        );

        $service->execute($input);
        return $this->success("Berhasil Mengubah Status Kelolosan Tim");
    }
}
