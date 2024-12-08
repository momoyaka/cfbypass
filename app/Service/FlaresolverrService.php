<?php

namespace App\Service;

use Illuminate\Support\Facades\Http;

class FlaresolverrService implements IProxyRequestService
{
    const HOST = 'flaresolverr';
    const PORT = 8191;
    const METHOD = 'v1';

    public static function bypass(string $url, string $method, array $data = [], array $cookies = [], ?string $proxy = null): array
    {
        $response = Http::post(self::getUrl(), [
            "cmd" => "request.get",
            "url" => $url,
            "maxTimeout" => 60000
        ]);
        return $response->json();
    }


    public static function getUrl(): string
    {
        return 'http://' . self::HOST . ':' . self::PORT . '/' . self::METHOD;
    }
}
