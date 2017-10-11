<?php

declare(strict_types=1);

namespace App\Console\Commands\Cache;

use Cache;
use App\Console\Commands\Command;

class TemporalClearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cache-temporal:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear temporal cache (run after deploy).';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handleCallback() : void
    {
        // clear version cache
        Cache::forget('app.version');

        $this->log('Cache cleared', self::LOG_LEVEL_INFO);
    }
}
