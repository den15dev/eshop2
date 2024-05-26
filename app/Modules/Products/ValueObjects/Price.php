<?php

namespace App\Modules\Products\ValueObjects;

use App\Modules\Currencies\CurrencyService;
use App\Modules\Currencies\Models\Currency;

class Price
{
    public readonly string $value;
    public readonly string $converted; // Clean numeric
    public readonly string $formatted; // With thousands and decimal separators
    public readonly string $formatted_full; // With currency sign

    private static Currency $from_currency;
    private static Currency $to_currency;


    public function __construct(
        string $value,
        ?string $from_currency_id = null,
        ?string $to_currency_id = null
    ) {
        $this->value = $value;
        $currencies = CurrencyService::getAll();

        if ($to_currency_id && $to_currency_id !== CurrencyService::$cur_currency->id) {
            self::$to_currency = $currencies->firstWhere('id', $to_currency_id);

            if ($to_currency_id === $from_currency_id) {
                $this->converted = $value;
            } else {
                self::$from_currency = $currencies->firstWhere('id', $from_currency_id);

                $this->converted = $this->getConverted($value, self::$from_currency->id, self::$to_currency->id);
            }

        } elseif ($from_currency_id && $from_currency_id !== CurrencyService::$cur_currency->id) {
            self::$to_currency = CurrencyService::$cur_currency;
            self::$from_currency = $currencies->firstWhere('id', $from_currency_id);

            $this->converted = $this->getConverted($value, self::$from_currency->id, self::$to_currency->id);

        } else {
            self::$to_currency = CurrencyService::$cur_currency;
            $this->converted = $value;
        }

        $this->formatted = $this->getFormatted();
        $this->formatted_full = $this->getFormattedFull();
    }


    /**
     * Null means current currency id.
     */
    public static function from(
        string $value,
        ?string $from_currency_id = null,
        ?string $to_currency_id = null
    ): self
    {
        return new self($value, $from_currency_id, $to_currency_id);
    }


    private static function getConverted(string $value, string $from_currency_id, string $to_currency_id): string
    {
        if ($from_currency_id === $to_currency_id) return $value;

        $exchanging_value = bcmul($value, self::$from_currency->exchange_rate);

        return bcdiv($exchanging_value, self::$to_currency->exchange_rate);
    }


    private function getFormatted(): string
    {
        return self::format(
            $this->converted,
            self::$to_currency->decimal_sep,
            self::$to_currency->thousands_sep
        );
    }


    private function getFormattedFull(): string
    {
        $formatted_full = $this->formatted;

        if (self::$to_currency->symbol_precedes) {
            $formatted_full = self::$to_currency->symbol . $formatted_full;
        } else {
            $formatted_full = $formatted_full . ' ' . self::$to_currency->symbol;
        }

        return $formatted_full;
    }


    private static function format(string $value, string $decimal_sep, string $thousands_sep): string
    {
        $formatted = number_format($value, 2, $decimal_sep, $thousands_sep);

        return preg_replace('/(.+)[,.]00$/', '$1', $formatted);
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