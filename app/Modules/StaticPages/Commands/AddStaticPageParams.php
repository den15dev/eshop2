<?php

namespace App\Modules\StaticPages\Commands;

use App\Console\Commands\BaseCommand;
use App\Modules\StaticPages\Models\StaticPage;
use App\Modules\StaticPages\Models\StaticPageParam;

class AddStaticPageParams extends BaseCommand
{
    protected $signature = 'app:add-static-page-params';

    protected $description = 'Fill DB with static page parameters';


    public function handle()
    {
        $this->addStaticPages();
        $this->addStaticPageParams();
    }


    private function addStaticPages(): void
    {
        $records = [
            [
                'id' => 1,
                'slug' => 'delivery',
                'name' => [
                    'en' => 'Delivery',
                    'ru' => 'Доставка',
                    'de' => 'Lieferung',
                ],
            ],
        ];

        if (StaticPage::count() == 0) {
            foreach ($records as $record) {
                StaticPage::create($record);
            }
            $this->info('Static pages added to main DB');
        } else {
            echo 'Static pages already exist in main DB' . PHP_EOL;
        }

        if (parent::$test_db_connection) {
            if (StaticPage::on(parent::$test_db_connection)->count() == 0) {
                foreach ($records as $record) {
                    StaticPage::on(parent::$test_db_connection)->create($record);
                }
                $this->info('Static pages added to testing DB');
            } else {
                echo 'Static pages already exist in testing DB' . PHP_EOL;
            }
        }
    }


    private function addStaticPageParams(): void
    {
        $records = include __DIR__ . '/../Data/static_page_params.php';

        if (StaticPageParam::count() == 0) {
            foreach ($records as $record) {
                StaticPageParam::create($record);
            }
            $this->info('Static page parameters added to main DB');
        } else {
            echo 'Static page parameters already exist in main DB' . PHP_EOL;
        }

        if (parent::$test_db_connection) {
            if (StaticPageParam::on(parent::$test_db_connection)->count() == 0) {
                foreach ($records as $record) {
                    StaticPageParam::on(parent::$test_db_connection)->create($record);
                }
                $this->info('Static page parameters added to testing DB');
            } else {
                echo 'Static page parameters already exist in testing DB' . PHP_EOL;
            }
        }
    }
}
