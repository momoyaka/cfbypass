<?php

namespace App\Http\Controllers;

use App\Http\Requests\BypassRequest;
use App\Service\FlaresolverrService;

class BypassController extends Controller
{
    public function bypass(BypassRequest $request): array
    {
        return FlaresolverrService::bypass($request->get('url'),);
    }
}
