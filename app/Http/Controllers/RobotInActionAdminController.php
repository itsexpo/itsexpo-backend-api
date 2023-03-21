<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\Application\Service\RobotInActionAdmin\RobotInActionAdminRequest;
use App\Core\Application\Service\RobotInActionAdmin\RobotInActionAdminService;
use App\Core\Application\Service\RobotInActionAdminConfirm\RobotInActionAdminConfirmRequest;
use App\Core\Application\Service\RobotInActionAdminConfirm\RobotInActionAdminConfirmService;
use App\Core\Application\Service\GetRobotInActionAdminDetail\GetRobotInActionAdminDetailService;

class RobotInActionAdminController extends Controller
{
    public function getTeam(Request $request, RobotInActionAdminService $service)
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

        $input = new RobotInActionAdminRequest(
            $request->input('per_page'),
            $request->input('page'),
            $request->input('filter'),
            $request->input('search'),
        );
        $response = $service->execute($input);
        return $this->successWithData($response, "Sukses mendapatkan data team robotik");
    }

    public function getDetail(Request $request, GetRobotInActionAdminDetailService $service)
    {
        $id = $request->route('team_id');
        $response = $service->execute($id);
        return $this->successWithData($response, "Sukses mendapatkan detail robotik");
    }

    public function confirmTeam(Request $request, RobotInActionAdminConfirmService $service)
    {
        $request->validate([
            'pembayaran_id' => 'required',
            'status_pembayaran_id' => 'required'
        ]);

        $input = new RobotInActionAdminConfirmRequest(
            $request->input('pembayaran_id'),
            $request->input('status_pembayaran_id')
        );

        $service->execute($input);
        return $this->success("Berhasil Mengubah Status Pembayaran");
    }
}
