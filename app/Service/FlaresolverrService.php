<?php

namespace App\Service;

use App\Models\Cookie;
use App\Models\Proxy;
use Carbon\Carbon;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class FlaresolverrService implements IProxyRequestService
{
    const HOST = 'flaresolverr';
    const PORT = 8191;
    const METHOD = 'v1';
    const TIMEOUT = 30;

    /**
     * @throws ConnectionException
     */
    public static function bypass(string $url, string $method, array $data = [], array $cookies = [], string|Proxy|null $proxy = null): array
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
            "maxTimeout" => config('flaresolver.timeout', 60) * 1000,
        ];

        if (!empty($cookies)) {
            $body['cookies'] = self::convertCookies($cookies);
        }

        if ($proxy instanceof Proxy) {
            $session = self::createSession($proxy);
            $body['session'] = $session;
            unset($body['cookies']);
        }

        if (is_string($proxy)) {
            $body['proxy'] = [
                'url' => $proxy
            ];
        }

        $response = Http::timeout(config('flaresolver.timeout', 60))->post(self::getUrl(), $body);

        $response = self::convertResponse($response->json());

        self::saveCookies($response['cookies']);

        return $response;
    }

    /**
     * @throws ConnectionException
     */
    public static function createSession(Proxy $proxy) : string {
        $body = [
            'cmd' => 'sessions.create',
            'session' => $proxy->host,
            'proxy' => [
                'url' => $proxy->scheme .'://'. $proxy->host . ':' . $proxy->port,
                'username' => $proxy->getAttribute('user') ?? null,
                'password' => $proxy->getAttribute('pass') ?? null,
            ]
        ];

        $response = Http::timeout(self::TIMEOUT)->post(self::getUrl(), $body);

        return $response['session'];
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

    /**
     * Удалить сессию
     *
     * @param Proxy $proxy
     * @return array
     * @throws ConnectionException
     */
    public static function deleteSession(Proxy $proxy): array
    {
        $body = [
            'cmd' => 'sessions.destroy',
            'session' => $proxy->host,
        ];

        $response = Http::timeout(config('flaresolver.timeout', 60))->post(self::getUrl(), $body);
        return $response->json();
    }
}
