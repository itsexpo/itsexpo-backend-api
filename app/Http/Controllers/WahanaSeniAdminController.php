<?php

namespace App\Http\Controllers;

use App\Core\Application\Service\WahanaSeniAdminConfirm\WahanaSeniAdminConfirmRequest;
use App\Core\Application\Service\WahanaSeniAdminConfirm\WahanaSeniAdminConfirmService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class WahanaSeniAdminController extends Controller
{
    public function confirm2DTeam(Request $request, WahanaSeniAdminConfirmService $service): JsonResponse
    {
        $request->validate([
            'pembayaran_id' => 'required',
            'status_pembayaran_id' => 'required'
        ]);

        $input = new WahanaSeniAdminConfirmRequest(
            $request->input('pembayaran_id'),
            $request->input('status_pembayaran_id'),
            '2D'
        );

        $service->execute($input);
        return $this->success("Berhasil Mengubah Status Pembayaran");
    }

    public function confirm3DTeam(Request $request, WahanaSeniAdminConfirmService $service): JsonResponse
    {
        $request->validate([
            'pembayaran_id' => 'required',
            'status_pembayaran_id' => 'required'
        ]);

        $input = new WahanaSeniAdminConfirmRequest(
            $request->input('pembayaran_id'),
            $request->input('status_pembayaran_id'),
            '3D'
        );

        $service->execute($input);
        return $this->success("Berhasil Mengubah Status Pembayaran");
    }
}
<?php

namespace App\Http\Controllers;

use App\Core\Application\Service\GetWahana3DAdminDetail\GetWahana3DAdminDetailService;
use App\Core\Application\Service\Wahana3DAdmin\Wahana3DAdminRequest;
use App\Core\Application\Service\Wahana3DAdmin\Wahana3DAdminService;
use Illuminate\Http\Request;

class WahanaSeniAdminController extends Controller
{
    public function getTeam(Request $request, Wahana3DAdminService $service)
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

        $input = new Wahana3DAdminRequest(
            $request->input('per_page'),
            $request->input('page'),
            $request->input('filter'),
            $request->input('search')
        );

        $response = $service->execute($input);
        return $this->successWithData($response, "Success Get Wahana 3D Team");
    }

    public function getDetailTeam(Request $request, GetWahana3DAdminDetailService $service)
    {
        $id = $request->route('team_id');
        $response = $service->execute($id);
        return $this->successWithData($response, "Success Get Wahana 3D Team Detail");
    }
}
