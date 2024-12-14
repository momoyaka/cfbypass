<?php

namespace App\Console\Commands;

use App\Service\Proxy\ProxyService;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;

class UpdateProxy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-proxy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Заполнить базу прокси';

    /**
     * Execute the console command.
     * @throws ConnectionException
     */
    public function handle(): void
    {
        (new ProxyService)->loadProxies();
        $this->info('Loaded proxies from file');
    }
}
