<?php

namespace App\Http\Controllers;

use App\Http\Requests\BypassRequest;
use App\Models\LogRequest;
use App\Models\Proxy;
use App\Service\FlaresolverrService;
use Illuminate\Http\Client\ConnectionException;

class BypassController extends Controller
{
    /**
     * @throws ConnectionException
     */
    public function bypass(BypassRequest $request): array
    {

        $tries = $request->get('tries', 3);

        $proxy = null;

        $result = ['status' => 'error'];
        if ($request->get('proxy', true) === false) {
            $result = FlaresolverrService::bypass(
                $request->get('url'),
                $request->get('method'),
                $request->get('data', []),
                $request->get('cookies', [])
            );
        }

        $try = 0;
        while ($result['status'] == 'error' && $tries > $try++) {

            $proxy = Proxy::query()->where('is_working', true)->orderBy('last_try')->first();

            $result = FlaresolverrService::bypass(
                $request->get('url'),
                $request->get('method'),
                $request->get('data', []),
                $request->get('cookies', []),
                $proxy
            );

            $proxy->setAttribute('last_try', now());

            $requestCount = (int)($proxy->getAttribute('request_count'));
            $proxy->setAttribute('request_count', ++$requestCount);

            $proxy->save();

            if ($result['status'] != 'error') {
                break;
            }
        }

        if (!$request->get('return_cookies', false)) {
            unset($result['cookies']);
        }

        $log = new LogRequest();

        $logResult = $result;
        unset($logResult['response']);

        $log->setAttribute('url', $request->get('url'));
        $log->setAttribute('method', $request->get('method', 'POST'));
        $log->setAttribute('body',
            json_encode(
                $request->get('data', []) +
                $request->get('cookies', []) +
                ['proxy' => $proxy?->toArray() ?? null]
            )
        );
        $log->setAttribute('result', json_encode($logResult));
        $log->setAttribute('status', 0);

        $log->save();

        return $result;
    }
}
