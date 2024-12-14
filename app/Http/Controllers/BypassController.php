<?php

namespace App\Http\Controllers;

use App\Http\Requests\BypassRequest;
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

        $result = ['status'=> 'error'];
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

            if ($result['status'] != 'error') {
                break;
            }

            $proxy->setAttribute('last_try', now());
            $proxy->save();
        }

        return $result;
    }
}
