<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\UrlShortener\UrlShortenerId;
use App\Core\Application\Service\AddUrlShortener\AddUrlShortenerRequest;
use App\Core\Application\Service\AddUrlShortener\AddUrlShortenerService;
use App\Core\Application\Service\GetUrlShortener\GetUrlShortenerRequest;
use App\Core\Application\Service\GetUrlShortener\GetUrlShortenerService;
use App\Core\Application\Service\DeleteUrlShortener\DeleteUrlShortenerRequest;
use App\Core\Application\Service\DeleteUrlShortener\DeleteUrlShortenerService;
use App\Core\Application\Service\UpdateUrlShortener\UpdateUrlShortenerRequest;
use App\Core\Application\Service\UpdateUrlShortener\UpdateUrlShortenerService;
use App\Core\Application\Service\GetUserUrlShortener\GetUserUrlShortenerRequest;
use App\Core\Application\Service\GetUserUrlShortener\GetUserUrlShortenerService;

class UrlShortenerController extends Controller
{
    public function add(Request $request, AddUrlShortenerService $service): JsonResponse
    {
        $request->validate([
            'long_url' => 'unique:url_shortener',
            'short_url' => 'unique:url_shortener',
        ]);

        $input = new AddUrlShortenerRequest(
            $request->input('long_url'),
            $request->input('short_url'),
        );

        DB::beginTransaction();
        try {
            $service->execute($input, $request->get('account'));
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->success("Url Shortener Berhasil Ditambahkan");
    }

    public function delete(Request $request, DeleteUrlShortenerService $service): JsonResponse
    {
        $url_id = new UrlShortenerId($request->input('url_id'));
        $input = new DeleteUrlShortenerRequest($url_id);
        
        DB::beginTransaction();
        try {
            $service->execute($input);
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();

        return $this->success("Url berhasil dihapus");
    }

    public function update(Request $request, UpdateUrlShortenerService $service): JsonResponse
    {
        $input = new UpdateUrlShortenerRequest(
            $request->input('url_id'),
            $request->input('long_url'),
            $request->input('short_url')
        );
        
        DB::beginTransaction();
        try {
            $service->execute($input, $request->get('account'));
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();

        return $this->success("Url berhasil diupdate");
    }

    public function get(Request $request, GetUrlShortenerService $service): JsonResponse
    {
        $request = new GetUrlShortenerRequest($request->input('short_url'));
        $long_url = $service->execute($request);
        return $this->successWithData($long_url, "Berhasil Mendapatkan URL");
    }

    public function index(Request $request, GetUserUrlShortenerService $service): JsonResponse
    {
        $input = new GetUserUrlShortenerRequest(
            $request->input('page'),
            $request->input('per_page')
        );
        $long_url = $service->execute($input, $request->get('account'));
        return $this->successWithData($long_url, "Berhasil Mendapatkan URL User");
    }
}
