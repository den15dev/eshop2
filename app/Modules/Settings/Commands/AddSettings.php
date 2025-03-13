<?php

namespace App\Modules\Settings\Commands;

use App\Console\Commands\BaseCommand;
use App\Modules\Settings\Models\Setting;

class AddSettings extends BaseCommand
{
    protected $signature = 'app:add-settings';

    protected $description = 'Fill DB with website settings';


    public function handle(): void
    {
        $records = include __DIR__ . '/../Data/settings.php';

        if (Setting::count() == 0) {
            foreach ($records as $record) {
                Setting::create($record);
            }
            $this->info('Website settings added to main DB');
        } else {
            echo 'Website settings already exist in main DB' . PHP_EOL;
        }

        if (parent::$test_db_connection) {
            if (Setting::on(parent::$test_db_connection)->count() == 0) {
                foreach ($records as $record) {
                    Setting::on(parent::$test_db_connection)->create($record);
                }
                $this->info('Website settings added to testing DB');
            } else {
                echo 'Website settings already exist in testing DB' . PHP_EOL;
            }
        }
    }
}
