<?php

namespace App\Service\Proxy;

use App\Models\Proxy;
use App\Service\FlaresolverrService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Storage;
use Nette\FileNotFoundException;

class ProxyService
{
    const PROXY_FILE = 'proxy_list.txt';

    /**
     * @throws ConnectionException
     */
    public function loadProxies(): void
    {
        $path = Storage::path(self::PROXY_FILE);

        if (!file_exists($path)) {
            throw new FileNotFoundException("Proxy file not found: " . $path);
        }

        $proxies = array_unique(array_filter(file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES), function ($url) {
            return parse_url($url) !== false;
        }));

        Proxy::query()->update(['is_working' => false]);

        foreach (Proxy::all() as $proxy) {
            FlaresolverrService::deleteSession($proxy);
        }

        foreach ($proxies as $proxy) {

            $proxy = parse_url($proxy);
            $proxy['is_working'] = true;

            Proxy::query()->upsert(
                $proxy,
                ['host', 'scheme', 'port']
            );
        }

    }
}
