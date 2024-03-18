<?php

namespace App\Modules\Currencies\Commands;

use App\Modules\Currencies\Models\Currency;
use App\Modules\Currencies\Sources\SourceEnum;
use Illuminate\Console\Command;

class AddCurrencies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-currencies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill DB with currencies';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->createCurrencies();
        $this->info('Currencies added to DB');
    }

    private function createCurrencies(): void
    {
        $records = [
            [
                'id' => 'usd',
                'name' => '{"en":"United States Dollar","ru":"Американский доллар","de":"US-Dollar"}',
                'symbol' => '$',
                'symbol_precedes' => true,
                'thousands_sep' => ',',
                'decimal_sep' => '.',
                'language_id' => 'en',
                'exchange_rate' => 92,
                'exchange_to' => 'rub',
                'source' => SourceEnum::Cbrf,
            ],
            [
                'id' => 'rub',
                'name' => '{"en":"Russian Ruble","ru":"Российский рубль","de":"Russischer Rubel"}',
                'symbol' => '&#8381;',
                'symbol_precedes' => false,
                'thousands_sep' => ' ',
                'decimal_sep' => ',',
                'language_id' => 'ru',
                'exchange_rate' => 1,
                'exchange_to' => 'rub',
                'source' => SourceEnum::Manual,
            ],
            [
                'id' => 'eur',
                'name' => '{"en":"Euro","ru":"Евро","de":"Euro"}',
                'symbol' => '&#8364;',
                'symbol_precedes' => true,
                'thousands_sep' => ',',
                'decimal_sep' => '.',
                'language_id' => 'de',
                'exchange_rate' => 96,
                'exchange_to' => 'rub',
                'source' => SourceEnum::Cbrf,
            ],
        ];

        Currency::upsert($records, 'id');
    }
}
