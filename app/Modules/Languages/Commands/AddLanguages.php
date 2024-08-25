<?php

namespace App\Modules\Languages\Commands;

use App\Console\Commands\BaseCommand;
use App\Modules\Languages\Models\Language;

class AddLanguages extends BaseCommand
{
    protected $signature = 'app:add-languages';

    protected $description = 'Fill DB with languages';


    public function handle()
    {
        $records = $this->getLanguages();

        if (Language::count() == 0) {
            foreach ($records as $record) {
                Language::create($record);
            }
            $this->info('Languages added to main DB');
        } else {
            echo 'Languages already exist in main DB' . PHP_EOL;
        }

        if (parent::$test_db_connection) {
            if (Language::on(parent::$test_db_connection)->count() == 0) {
                foreach ($records as $record) {
                    Language::on(parent::$test_db_connection)->create($record);
                }
                $this->info('Languages added to testing DB');
            } else {
                echo 'Languages already exist in testing DB' . PHP_EOL;
            }
        }
    }


    private function getLanguages(): array
    {
        return [
            ['id' => 'en', 'name' => 'English', 'active' => true, 'default' => true, 'fallback' => true],
            ['id' => 'ru', 'name' => 'Русский', 'active' => true, 'default' => false, 'fallback' => false],
            ['id' => 'de', 'name' => 'Deutsch', 'active' => true, 'default' => false, 'fallback' => false],
        ];
    }
}
