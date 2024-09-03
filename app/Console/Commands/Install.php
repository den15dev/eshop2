<?php

namespace App\Console\Commands;

use App\Modules\Categories\Commands\AddCategories;
use App\Modules\Currencies\Commands\AddCurrencies;
use App\Modules\Currencies\Commands\UpdateRates;
use App\Modules\Languages\Commands\AddLanguages;
use App\Modules\Promos\Commands\AddPromos;
use App\Modules\StaticPages\Commands\AddStaticPageParams;
use App\Modules\Shops\Commands\AddShops;
use Database\Seeders\TestingDBSeeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class Install extends BaseCommand
{
    protected $signature = 'app:install';

    protected $description = 'Install application';


    public function __construct(
        private readonly TestingDBSeeder $testingDBSeeder
    )
    {
        parent::__construct();
    }


    public function handle(): void
    {
        $this->setTestDbConnection();

        $this->createImageDirs();
        $this->call(AddLanguages::class);
        $this->call(AddCurrencies::class);
        $this->call(UpdateRates::class, ['source' => 'cbrf']);
        $this->call(AddStaticPageParams::class);
        $this->call(AddShops::class);
        $this->call(AddPromos::class);
        $this->call(AddCategories::class);
        $this->seedTestingDB();
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


    private function setTestDbConnection(): void
    {
        echo 'Trying to connect to testing database. Please wait...' . PHP_EOL;

        try {
            DB::connection(config('database.testing'))->getPdo();

            echo 'Testing database is up, will be populated too.' . PHP_EOL;
            parent::$test_db_connection = config('database.testing');

            echo 'Running migrations for testing database...' . PHP_EOL;
            Artisan::call('migrate', ['--database' => config('database.testing')]);
            $this->info('Migrations for testing DB ran');

        } catch (\Exception $e) {
            echo 'Can\'t connect to testing database. Skipping.' . PHP_EOL;
        }
    }


    private function seedTestingDB(): void
    {
        if (parent::$test_db_connection) {
            echo 'Seeding testing database...' . PHP_EOL;
            $this->testingDBSeeder->run();
            $this->info('Testing DB seeded');
        }
    }
}
