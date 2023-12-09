<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install application';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->call(AddLanguages::class);
        $this->call(AddSettings::class);
        $this->info('Application installed');
    }
}
