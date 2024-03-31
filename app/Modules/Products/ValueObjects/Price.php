<?php

namespace App\Modules\Products\ValueObjects;

use App\Modules\Currencies\CurrencyService;
use App\Modules\Currencies\Models\Currency;

class Price
{
    public readonly ?string $value;
    public readonly string $currency_id;
    public readonly string $converted; // Clean numeric
    public readonly string $formatted; // With thousands separators
    public readonly string $formatted_full; // With currency sign

    private readonly Currency $cur_currency;


    public function __construct(?string $value, ?string $currency_id = null)
    {
        $this->value = $value;

        $cur_currency = CurrencyService::$cur_currency;
        $this->currency_id = $currency_id ?? $cur_currency->id;
        $this->cur_currency = $cur_currency;

        $this->converted = $this->getConverted();
        $this->formatted = $this->getFormatted();
        $this->formatted_full = $this->getFormattedFull();
    }


    public static function from(?string $value, ?string $currency_id = null): self
    {
        return new self($value, $currency_id);
    }


    private function getConverted(): string
    {
        if ($this->currency_id === $this->cur_currency->id) {
            return $this->value;
        }

        $currencies = CurrencyService::getAll();
        $cur_currency = $this->cur_currency;

        // Calculate in exchanging currency
        $sku_exch_rate = $currencies->firstWhere('id', $this->currency_id)->exchange_rate;
        $exchanging_value = bcmul($this->value, $sku_exch_rate);

        // Calculate in current currency
        return bcdiv($exchanging_value, $cur_currency->exchange_rate);
    }


    private function getFormatted(): string
    {
        $cur_currency = $this->cur_currency;

        $formatted = number_format($this->converted, 2, $cur_currency->decimal_sep, $cur_currency->thousands_sep);
        $formatted = preg_replace('/(.+)[,.]00$/', '$1', $formatted);

        return $formatted;
    }


    private function getFormattedFull(): string
    {
        $cur_currency = $this->cur_currency;
        $formatted_full = $this->formatted;

        if ($cur_currency->symbol_precedes) {
            $formatted_full = $cur_currency->symbol . $formatted_full;
        } else {
            $formatted_full = $formatted_full . ' ' . $cur_currency->symbol;
        }

        return $formatted_full;
    }


    public static function parse(string $input): string
    {
        $num = preg_replace('/[^\d.,]/', '', $input);
        $num = str_replace(',', '.', $num);
        $num_arr = explode('.', $num);
        if (count($num_arr) > 1) {
            $decimal = array_pop($num_arr);
            $num = implode('', $num_arr) . '.' . $decimal;
        }

        return $num;
    }
}