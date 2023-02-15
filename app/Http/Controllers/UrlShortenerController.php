<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Core\Application\Service\AddUrlShortener\AddUrlShortenerRequest;
use App\Core\Application\Service\AddUrlShortener\AddUrlShortenerService;
use App\Core\Application\Service\GetUrlShortener\GetUrlShortenerRequest;
use App\Core\Application\Service\GetUrlShortener\GetUrlShortenerService;

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

    public function get(Request $request, GetUrlShortenerService $service, string $short_url): JsonResponse
    {
        $request = new GetUrlShortenerRequest($short_url);
        $long_url = $service->execute($request);
        return $this->success($long_url);
    }
}
