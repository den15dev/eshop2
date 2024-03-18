<?php

namespace App\Modules\Currencies\Sources;

use Illuminate\Support\Collection;

class CbrfSource extends Source
{

    public function enum(): SourceEnum
    {
        return SourceEnum::Cbrf;
    }

    public function getRates(): Collection
    {
        $xml = file_get_contents('https://cbr.ru/scripts/XML_daily.asp');
        $obj = simplexml_load_string($xml);

        $prices = new Collection();

        foreach ($obj->Valute as $data) {
            $prices->push(new SourceRate(
                currency_id: mb_strtolower($data->CharCode),
                value: str_replace(',', '.', $data->VunitRate),
            ));
        }

        return $prices;
    }
}