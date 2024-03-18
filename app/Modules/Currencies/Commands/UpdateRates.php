<?php

namespace App\Modules\Currencies\Commands;

use App\Modules\Currencies\CurrencyService;
use App\Modules\Currencies\Sources\SourceEnum;
use Illuminate\Console\Command;

class UpdateRates extends Command
{
    protected $signature = 'app:update-currency-rates {source}'; // cbrf

    protected $description = 'Update currency exchange rates';


    /**
     * Execute the console command.
     */
    public function handle(CurrencyService $currencyService)
    {
        $this->updateRates($currencyService);
        $this->info('Currency exchange rates updated');
    }


    public function updateRates(CurrencyService $currencyService): void
    {
        $source = SourceEnum::tryFrom($this->argument('source'));
        $source = $currencyService->getSource($source);
        $currencyService->updateRates()->run($source);
    }
}