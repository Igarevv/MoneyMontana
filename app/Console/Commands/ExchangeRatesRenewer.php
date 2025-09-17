<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ExchangeRatesRenewer extends Command
{
    protected $signature = 'app:exchange-rates-update {base} {--test}';

    protected $description = 'Update exchange rates from third-party API.';

    public function handle(): int
    {
        $base = strtolower($this->argument('base') ?? 'USD');

        try {

            $response = Http::get("https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@latest/v1/currencies/$base.json");

            if (!$response->ok()) {
                $this->info("Error fetching current exchange rates from main service. Trying backup option...");

                $response = Http::get("https://latest.currency-api.pages.dev/v1/currencies/$base.json");

                if (!$response->ok()) {
                    $this->error("Failed to fetch currencies.");

                    return 1;
                }
            }
        } catch (\Exception $e) {
            $this->error("Failed to fetch currencies: " . $e->getMessage());

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

        $connection = $this->option('test') ? 'pgsql_testing' : 'pgsql';

        DB::connection($connection)
            ->table('exchange_rates')
            ->upsert(
                $rows->toArray(),
                ['source_currency_code', 'target_currency_code'],
                ['exchange_rate', 'updated_at']
            );

        $this->info("Exchange rates was updated.");

        return 0;
    }
}
