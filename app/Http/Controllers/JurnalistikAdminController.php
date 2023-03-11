<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\Application\Service\JurnalistikAdmin\JurnalistikAdminRequest;
use App\Core\Application\Service\JurnalistikAdmin\JurnalistikAdminService;
use app\Core\Application\Service\JurnalistikAdminConfirm\JurnalistikAdminConfirmRequest;
use app\Core\Application\Service\JurnalistikAdminConfirm\JurnalistikAdminConfirmService;
use App\Core\Application\Service\GetJurnalistikAdminDetail\GetJurnalistikAdminDetailService;

class JurnalistikAdminController extends Controller
{
    public function getTeam(Request $request, JurnalistikAdminService $service)
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
            'search' => 'string',
        ]);

        $input = new JurnalistikAdminRequest(
            $request->input('per_page'),
            $request->input('page'),
            $request->input('filter'),
            $request->input('search'),
        );
        $response = $service->execute($input);
        return $this->successWithData($response, "success get jurnalistik team data");
    }

    public function getDetail(Request $request, GetJurnalistikAdminDetailService $service)
    {
        $id = $request->route('team_id');
        $response = $service->execute($id);
        return $this->successWithData($response, "Success get jurnalistik team detail");
    }

    public function confirmTeam(Request $request, JurnalistikAdminConfirmService $service)
    {
        $request->validate([
          'id' => 'required',
          'status' => 'required'
        ]);

        $input = new JurnalistikAdminConfirmRequest(
            $request->input('id'),
            $request->input('status')
        );
        print_r("lmao");

        $service->execute($input);
        return $this->success("Sukses Mengubah Status Pembayaran");
    }
}
