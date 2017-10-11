<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Exceptions\CommandException;

class Command extends \Illuminate\Console\Command
{
    protected const LOG_LEVEL_COMMENT = 'comment';
    protected const LOG_LEVEL_INFO    = 'info';
    protected const LOG_LEVEL_WARNING = 'warn';
    protected const LOG_LEVEL_ERROR   = 'error';

    protected $id;

    public function handle() : void
    {
        $this->start();

        $this->handleCallback();

        $this->finish();
    }

    protected function handleCallback() : void
    {
        throw new CommandException('Must be implement handleCallback() method');
    }

    protected function start() : void
    {
        $this->id = md5(microtime());

        $this->log('Running');
    }

    protected function finish() : void
    {
        $this->log('Finished');
    }

    protected function log(string $text, string $level = self::LOG_LEVEL_INFO) : void
    {
        if (!in_array($level, [
            self::LOG_LEVEL_COMMENT, self::LOG_LEVEL_INFO, self::LOG_LEVEL_WARNING, self::LOG_LEVEL_ERROR
        ])) {
            throw new CommandException('Log level invalid');
        }

        $log = strtoupper($level) .  ': ' . $this->id . ' - [' . date('Y-m-d H:i:s') . '] - '
            . $this->signature . ': ' . $text;

        $this->$level($log);
    }
}
