<?php

declare(strict_types=1);

namespace App\Helpers;

use Brick\Money\ExchangeRateProvider\PDOProvider;
use Brick\Money\ExchangeRateProvider\PDOProviderConfiguration;
use Illuminate\Support\Facades\DB;

class CurrencyConverter
{
    public static function init(): \Brick\Money\CurrencyConverter
    {
        $configuration = new PDOProviderConfiguration(
            tableName: 'exchange_rates',
            exchangeRateColumnName: 'exchange_rate',
            sourceCurrencyColumnName: 'source_currency_code',
            targetCurrencyColumnName: 'target_currency_code',
        );

        $provider = new PDOProvider(DB::getPdo(), $configuration);

        return new \Brick\Money\CurrencyConverter($provider);
    }
}