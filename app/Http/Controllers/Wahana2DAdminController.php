<?php

namespace App\Http\Controllers;

use App\Core\Application\Service\GetWahana2DAdminDetail\GetWahana2DAdminDetailService;
use App\Core\Application\Service\Wahana2DAdmin\Wahana2DAdminRequest;
use App\Core\Application\Service\Wahana2DAdmin\Wahana2DAdminService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Wahana2DAdminController extends Controller
{
    public function getPeserta(Request $request, Wahana2DAdminService $service)
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

        $input = new Wahana2DAdminRequest(
            $request->input('per_page'),
            $request->input('page'),
            $request->input('filter'),
            $request->input('search')
        );

        $output = $service->execute($input);
        return $this->successWithData($output, "success get peserta wahana2D");
    }

    public function getDetail(Request $request, GetWahana2DAdminDetailService $service)
    {
        $id = $request->route('peserta_id');
        $response = $service->execute($id);
        return $this->successWithData($response, "Sukses mendapatkan detail peserta Wahana2D");
    }
}
