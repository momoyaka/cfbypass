<?php

namespace App\Http\Controllers;

use App\Http\Requests\BypassRequest;
use App\Service\FlaresolverrService;
use Illuminate\Http\Client\ConnectionException;

class BypassController extends Controller
{
    /**
     * @throws ConnectionException
     */
    public function bypass(BypassRequest $request): array
    {
        return FlaresolverrService::bypass(
            $request->get('url'),
            $request->get('method'),
            $request->get('data', []),
            $request->get('cookies', []),
            $request->get('proxy')
        );
    }
}
