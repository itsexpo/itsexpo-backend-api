<?php

namespace App\Http\Controllers;

use App\Core\Application\Service\RegisterWahana3D\Ketua\RegisterWahana3DKetuaRequest;
use App\Core\Application\Service\RegisterWahana3D\Ketua\RegisterWahana3DKetuaService;
use App\Core\Application\Service\RegisterWahana3D\Member\RegisterWahana3DMemberRequest;
use App\Core\Application\Service\RegisterWahana3D\Member\RegisterWahana3DMemberService;
use App\Core\Domain\Models\Wahana3D\Wahana3DMemberType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class Wahana3DController extends Controller
{
    public function register(Request $request, RegisterWahana3DKetuaService $wahana_3d_ketua, RegisterWahana3DMemberService $wahana_3d_member)
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
            $request->file('ktm')
        );

        $input_member = array_map(function (array $member, array $file) {
            return new RegisterWahana3DMemberRequest(
                $member['departemen_id'],
                $member['name'],
                $member['nrp'],
                $member['kontak'],
                Wahana3DMemberType::MEMBER,
                $file['ktm']
            );
        }, $request->input('mahasiswa'), $request->file('mahasiswa'));

        DB::beginTransaction();
        try {
            $wahana_3d_ketua->execute($input_ketua, $request->get('account'));
            $wahana_3d_member->execute($input_member, $request->get('account'));
        } catch(Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->success("Berhasil Membuat Tim");
    }
}
