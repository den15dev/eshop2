<?php

namespace App\Modules\Promos\Commands;

use App\Console\Commands\BaseCommand;
use App\Modules\Promos\Models\Promo;

class AddPromos extends BaseCommand
{
    protected $signature = 'app:add-promos';

    protected $description = 'Fill DB with promos';


    public function handle()
    {
        $records = include __DIR__ . '/../Data/promos.php';

        if (Promo::count() == 0) {
            foreach ($records as $record) {
                Promo::create($record);
            }
            $this->info('Promos added to main DB');
        } else {
            echo 'Promos already exist in main DB' . PHP_EOL;
        }

        if (parent::$test_db_connection) {
            if (Promo::on(parent::$test_db_connection)->count() == 0) {
                foreach ($records as $record) {
                    Promo::on(parent::$test_db_connection)->create($record);
                }
                $this->info('Promos added to testing DB');
            } else {
                echo 'Promos already exist in testing DB' . PHP_EOL;
            }
        }
    }
}
