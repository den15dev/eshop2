<?php

namespace Tests\Feature\Common;

use App\Modules\Currencies\CurrencyService;
use App\Modules\Products\ValueObjects\Price;
use Tests\TestCase;

class CurrencyTest extends TestCase
{
    public function test_currency_conversion(): void
    {
        $currencies = CurrencyService::getAll();
        $amount = 1000;
        $from = $currencies->firstWhere('id', 'usd');
        $to = $currencies->firstWhere('id', 'rub');

        $price = Price::from($amount, $from->id, $to->id);

        $converted = $amount * $from->exchange_rate / $to->exchange_rate;

        $this->assertEquals($converted, $price->converted);
    }


    public function test_currency_switching(): void
    {
        $currency_id = 'rub';
        $data = [
            'new_currency' => $currency_id,
        ];

        $response = $this->post(route('currency'), $data);

        $response->assertStatus(302);
        $response->assertCookie(CurrencyService::COOKIE, $currency_id);

        $response = $this->withCookie(CurrencyService::COOKIE, $currency_id)->get(route('catalog', 'cpu'));

        $response->assertStatus(200);
        $response->assertSee('&#8381;', false);
    }
}
