<?php

namespace App\Http\Controllers;

use App\Core\Application\Service\RegisterWahana2D\RegisterWahana2DRequest;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Core\Application\Service\RegisterWahana2D\RegisterWahana2DService;

class Wahana2DController extends Controller
{
    public function register(Request $request, RegisterWahana2DService $service)
    {
        // dd("asd");

        $request->validate([
            'departemen_id' => 'max:512|string',
            'name' => 'required|string',
            'nrp' => 'max:512|required|string',
            'kontak' => 'required|string',
            'email' => 'required|string',
        ]);

        $input = new RegisterWahana2DRequest(
            $request->input('name'),
            $request->input('nrp'),
            $request->input('departemen_id'),
            $request->input('email'),
            $request->input('kontak'),
            $request->file('ktm')
        );

        // dd($input);
        DB::beginTransaction();
        try
        {
            $service->execute($input, $request->get('account'));
        }
        catch (Throwable $e)
        {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        
        return $this->success("Berhasil Mendaftarkan ke Wahana 2D");
    }
}