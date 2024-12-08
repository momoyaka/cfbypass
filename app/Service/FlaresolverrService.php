<?php

namespace App\Service;

use App\Models\Cookie;
use Carbon\Carbon;
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
        $host = parse_url($url, PHP_URL_HOST);

        $existCookies = Cookie::query()->where('host', $host)->where('expiry', '>', now())->get(['key', 'value', 'expiry']);

        /** @var Cookie $cookie */
        foreach ($existCookies as $cookie) {
            $cookies[$cookie->key] = $cookie->value;
        }

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

        $response = self::convertResponse($response->json());

        self::saveCookies($response['cookies']);

        return $response;
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

    private static function saveCookies(array $cookies): void
    {
        if (empty($cookies)) {
            return;
        }

        foreach ($cookies as $cookie) {
            $values = [
                'host' => ltrim($cookie['domain'], '.'),
                'key' => $cookie['name'],
                'value' => $cookie['value'],
            ];

            $updates = ['value'];

            if (!empty($cookie['expiry'])) {
                $values['expiry'] = Carbon::createFromTimestamp($cookie['expiry']);
                $updates[] = 'expiry';
            }

            Cookie::query()->upsert(
                $values,
                ['host', 'key'],
                $updates
            );
        }
    }
}
