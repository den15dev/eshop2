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
     */
    protected $signature = 'app:install';

    /**
     * The console command description.
     */
    protected $description = 'Install application';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->createImageDirs();
        $this->call(AddLanguages::class);
        $this->call(AddCurrencies::class);
        $this->call(AddStaticPageParams::class);
        $this->call(AddShops::class);
        $this->call(AddPromos::class);
        $this->call(AddCategories::class);
        $this->info('Application installed');
    }


    private function createImageDirs(): void
    {
        $image_dir = storage_path('app/public/images');
        $dir_names = [
            'brands',
            'categories',
            'products',
            'promos',
            'users',
        ];

        if (!file_exists($image_dir) || !is_dir($image_dir)) {
            mkdir($image_dir);
        }

        foreach ($dir_names as $dir_name) {
            $dir_path = $image_dir . '/' . $dir_name;
            if (!file_exists($dir_path) || !is_dir($dir_path)) {
                mkdir($dir_path);
            }
        }
    }
}
