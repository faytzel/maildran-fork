<?php

declare(strict_types=1);

namespace App\Services;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessUtils;

class ConsoleService
{
    public function run(string $command, int $timeout = 30) : string
    {
        $process = new Process($command);
        $process->setTimeout($timeout);

        // si falla el comando, lanza Symfony\Component\Process\Exception\ProcessFailedException
        $process->mustRun();
        $output = trim($process->getOutput());

        return $output;
    }

    public function escapeArgument(string $value) : string
    {
        return ProcessUtils::escapeArgument($value);
    }
}
