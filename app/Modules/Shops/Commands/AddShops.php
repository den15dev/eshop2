<?php

namespace App\Modules\Shops\Commands;

use App\Console\Commands\BaseCommand;
use App\Modules\Shops\Models\Shop;

class AddShops extends BaseCommand
{
    protected $signature = 'app:add-shops';

    protected $description = 'Fill DB with shops';


    public function handle(): void
    {
        $records = include __DIR__ . '/../Data/shops.php';

        foreach ($records as $index => &$pre_record) {
            $pre_record['images'] = NULL;
            $pre_record['sort'] = $index + 1;
            $pre_record['is_active'] = true;
        }

        if (Shop::count() == 0) {
            foreach ($records as $record) {
                Shop::create($record);
            }
            $this->info('Shops added to main DB');
        } else {
            echo 'Shops already exist in main DB' . PHP_EOL;
        }

        if (parent::$test_db_connection) {
            if (Shop::on(parent::$test_db_connection)->count() == 0) {
                foreach ($records as $record) {
                    Shop::on(parent::$test_db_connection)->create($record);
                }
                $this->info('Shops added to testing DB');
            } else {
                echo 'Shops already exist in testing DB' . PHP_EOL;
            }
        }
    }
}
