<?php

namespace App\Modules\Currencies\Commands;

use App\Console\Commands\BaseCommand;
use App\Modules\Currencies\Models\Currency;

class AddCurrencies extends BaseCommand
{
    protected $signature = 'app:add-currencies';

    protected $description = 'Fill DB with currencies';


    public function handle(): void
    {
        $records = include __DIR__ . '/../Data/currencies.php';

        if (Currency::count() == 0) {
            foreach ($records as $record) {
                Currency::create($record);
            }
            $this->info('Currencies added to main DB');
        } else {
            echo 'Currencies already exist in main DB' . PHP_EOL;
        }

        if (parent::$test_db_connection) {
            if (Currency::on(parent::$test_db_connection)->count() == 0) {
                foreach ($records as $record) {
                    Currency::on(parent::$test_db_connection)->create($record);
                }
                $this->info('Currencies added to testing DB');
            } else {
                echo 'Currencies already exist in testing DB' . PHP_EOL;
            }
        }
    }
}
