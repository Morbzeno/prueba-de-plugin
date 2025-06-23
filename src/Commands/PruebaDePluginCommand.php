<?php

namespace Morbzeno\PruebaDePlugin\Commands;

use Illuminate\Console\Command;

class PruebaDePluginCommand extends Command
{
    public $signature = 'prueba-de-plugin';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
