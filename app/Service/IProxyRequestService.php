<?php

namespace App\Service;

interface IProxyRequestService
{

    public static function bypass(string $url, string $method, array $data, array $cookies, string $proxy): array;

    public static function getUrl(): string;
}
