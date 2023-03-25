<?php

namespace App\Http\Controllers;

use App\Core\Application\Service\KTIAdmin\KTIAdminRequest;
use App\Core\Application\Service\KTIAdmin\KTIAdminService;
use Illuminate\Http\Request;

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
}