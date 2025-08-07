<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ExchangeRatesRenewer extends Command
{
    protected $signature = 'app:exchange-rates-update {base}';

    protected $description = 'Update exchange rates from third-party API.';

    public function handle(): int
    {
        $base = strtolower($this->argument('base') ?? 'USD');

        $response = Http::get("https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@latest/v1/currencies/$base.json");

        if (! $response->ok()) {
            $this->error("Error fetching current exchange rates.");
            return 1;
        }

        $data = $response->json();

        $allowedCurrencies = collect(config('currency.allowed'));

        $currenciesFromApi = collect($data[$base])->mapWithKeys(function (string $value, string $key) {
            return [
                strtoupper($key) => $value,
            ];
        });

        $neededCurrencies = $currenciesFromApi->only($allowedCurrencies);

        $now = now();

        $rows = $neededCurrencies
            ->map(function (string $rate, string $currency) use ($base, $now) {
                if ($base === $currency) {
                    return null;
                }

                return [
                    'source_currency_code' => strtoupper($base),
                    'target_currency_code' => $currency,
                    'exchange_rate' => $rate,
                    'updated_at' => $now,
                ];
            })
            ->filter()
            ->values();

        DB::table('exchange_rates')->upsert(
            $rows->toArray(),
            ['source_currency_code', 'target_currency_code'],
            ['exchange_rate', 'updated_at'],
        );

        $this->info("Exchange rates was updated.");

        return 0;
    }
}
