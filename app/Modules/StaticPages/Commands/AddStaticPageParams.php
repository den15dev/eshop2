<?php

namespace App\Modules\StaticPages\Commands;

use App\Modules\StaticPages\Models\StaticPage;
use App\Modules\StaticPages\Models\StaticPageParam;
use Illuminate\Console\Command;

class AddStaticPageParams extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-static-page-params';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill DB with static page parameters';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->addStaticPages();
        $this->addStaticPageParams();
        $this->info('Static page parameters added to DB');
    }


    private function addStaticPages(): void
    {
        $records = [
            [
                'id' => 1,
                'slug' => 'delivery',
                'name' => '{"en":"Delivery","ru":"Доставка","de":"Lieferung"}',
            ],
        ];

        StaticPage::upsert($records, 'id');
    }


    private function addStaticPageParams(): void
    {
        $records = [
            [
                'name' => 'email',
                'static_page_id' => null,
                'val' => '{"en":"info@eshop2.den15.dev"}',
                'description' => '{"en":"Email","ru":"Адрес электронной почты","de":"Email"}',
            ],
            [
                'name' => 'phone',
                'static_page_id' => null,
                'val' => '{"en":"+44 20 2345 6789","ru":"8 (800) 456-78-90","de":"+49 30 2345 6789"}',
                'description' => '{"en":"Phone number","ru":"Номер телефона","de":"Telefonnummer"}',
            ],

            [
                'name' => 'express_cost1',
                'static_page_id' => 1,
                'val' => '{"en":"$8.90","ru":"850 рублей","de":"8.50 €"}',
                'description' => '{"en":"Delivery cost within a 2-hour interval for product\'s weight up to 15 kg","ru":"Стоимость доставки товара в 2-х часовой интервал до 15 кг","de":"Die Versandkosten betragen innerhalb von 2 Stunden für ein Produktgewicht bis 15 kg"}',
            ],
            [
                'name' => 'express_cost2',
                'static_page_id' => 1,
                'val' => '{"en":"$7.90","ru":"750 рублей","de":"7.50 €"}',
                'description' => '{"en":"Delivery cost within a 4-hour interval for product\'s weight up to 15 kg","ru":"Стоимость доставки товара в 4-х часовой интервал до 15 кг","de":"Die Versandkosten betragen innerhalb von 4 Stunden für ein Produktgewicht bis 15 kg"}',
            ],
            [
                'name' => 'express_cost3',
                'static_page_id' => 1,
                'val' => '{"en":"$40","ru":"4000 рублей","de":"38 €"}',
                'description' => '{"en":"Delivery cost within a 4-hour interval for product\'s weight over 15 kg","ru":"Стоимость доставки товара в 4-х часовой интервал свыше 15 кг","de":"Die Versandkosten betragen innerhalb von 4 Stunden für ein Produktgewicht über 15 kg"}',
            ],

            [
                'name' => 'cost_under10',
                'static_page_id' => 1,
                'val' => '{"en":"$6.50","ru":"599 рублей","de":"6.50 €"}',
                'description' => '{"en":"Weight up to 10 kg","ru":"Вес до 10 кг","de":"Gewicht bis 10 kg"}',
            ],
            [
                'name' => 'cost_10_25',
                'static_page_id' => 1,
                'val' => '{"en":"$7.50","ru":"799 рублей","de":"7.50 €"}',
                'description' => '{"en":"Weight from 10 to 25 kg","ru":"Вес от 10 до 25 кг","de":"Gewicht von 10 bis 25 kg"}',
            ],
            [
                'name' => 'cost_25_100',
                'static_page_id' => 1,
                'val' => '{"en":"$8.50","ru":"899 рублей","de":"8.50 €"}',
                'description' => '{"en":"Weight from 25 to 100 kg","ru":"Вес от 25 до 100 кг","de":"Gewicht von 25 bis 100 kg"}',
            ],
            [
                'name' => 'cost_100_300',
                'static_page_id' => 1,
                'val' => '{"en":"$19.50","ru":"1990 рублей","de":"19.50 €"}',
                'description' => '{"en":"Weight from 100 to 300 kg","ru":"Вес от 100 до 300 кг","de":"Gewicht von 100 bis 300 kg"}',
            ],
        ];

        StaticPageParam::upsert($records, 'id');
    }
}
