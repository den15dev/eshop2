<?php

namespace App\Console\Commands;

use App\Modules\Categories\Commands\AddCategories;
use App\Modules\Currencies\Commands\AddCurrencies;
use App\Modules\Languages\Commands\AddLanguages;
use App\Modules\Promos\Commands\AddPromos;
use App\Modules\StaticPages\Commands\AddStaticPageParams;
use App\Modules\Shops\Commands\AddShops;
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
        $this->call(AddCurrencies::class);
        $this->call(AddStaticPageParams::class);
        $this->call(AddShops::class);
        $this->call(AddPromos::class);
        $this->call(AddCategories::class);
        $this->info('Application installed');
    }
}
