<?php

namespace App\Service;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class FlaresolverrService implements IProxyRequestService
{
    const HOST = 'flaresolverr';
    const PORT = 8191;
    const METHOD = 'v1';

    /**
     * @throws ConnectionException
     */
    public static function bypass(string $url, string $method, array $data = [], array $cookies = [], ?string $proxy = null): array
    {
        $body = [
            "cmd" => "request.get",
            "url" => $url,
            "maxTimeout" => 60000,
        ];

        if (!empty($proxy)) {
            $body['proxy'] = [
                'url' => $proxy
            ];
        }

        if (!empty($cookies)) {
            $body['cookies'] = self::convertCookies($cookies);
        }

        $response = Http::timeout(60)->post(self::getUrl(), $body);

        return self::convertResponse($response->json());
    }


    public static function getUrl(): string
    {
        return 'http://' . self::HOST . ':' . self::PORT . '/' . self::METHOD;
    }

    private static function convertCookies(array $cookies): array
    {
        return array_map(function ($key, $value) {
            return [
                'name' => $key,
                'value' => $value
            ];
        }, array_keys($cookies), array_values($cookies));
    }

    private static function convertResponse(mixed $json): array
    {

        $actual = [];

        $actual['status'] = data_get($json, 'status', 'error');
        $actual['cookies'] = data_get($json, 'solution.cookies', []);
        $actual['response'] = data_get($json, 'solution.response', []);

        return $actual;
    }
}
