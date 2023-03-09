<?php

namespace App\Core\Application\Service\GetJurnalistikAdminDetail;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Application\Service\JurnalistikAdmin\JurnalistikAdminRequest;
use App\Core\Application\Service\JurnalistikAdmin\JurnalistikAdminService;

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

    public function getDetail($team_id, GetJurnalistikAdminDetailService $service)
    {
        $response = $service->execute($team_id);
        return $this->successWithData("success get jurnalistik team detail", $response);
    }
}
