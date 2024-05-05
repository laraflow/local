<?php

namespace Laraflow\Local\Commands;

use Illuminate\Console\Command;

class LocalCommand extends Command
{
    public $signature = 'local';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
