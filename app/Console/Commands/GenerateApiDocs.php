<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class GenerateApiDocs extends Command
{
    protected $signature = 'api:docs:generate';
    protected $description = 'Generates the api documentation based on ./resource/api-docs/v1 files';

    public function handle(): void
    {
        $this->info('Generating api-docs for API ver. 1' . PHP_EOL);

        $process = Process::fromShellCommandline(
            'redocly bundle ./resources/api-docs/v1/openapi.yaml -o public/api-docs-v1.yaml'
        );
        $process->run();

        if (!$process->isSuccessful()) {
            $this->error($process->getErrorOutput());
        } else {
            $this->info('SUCCESS');
            $this->line($process->getErrorOutput());
        }
    }
}
