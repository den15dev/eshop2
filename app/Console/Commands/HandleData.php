<?php

namespace App\Console\Commands;

use Database\Seeders\MainHandler;
use Illuminate\Console\Command;

class HandleData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:handle-data {category_slug}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Translate products\' JSON files, generate and translate brands\' JSON files, seed database, download and handle images';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        MainHandler::run($this->argument('category_slug'));
    }
}
