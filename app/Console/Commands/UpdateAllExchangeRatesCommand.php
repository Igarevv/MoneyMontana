<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class UpdateAllExchangeRatesCommand extends Command
{
    protected $signature = 'app:update-all-exchange-rates-command {--test}';

    protected $description = 'Initial update for all exchange rates.';

    public function handle(): void
    {
        $allCurrencies = config('currency.allowed');

        foreach ($allCurrencies as $currency) {
            $this->info('Updating currency ' . $currency);

            if ($this->option('test')) {
                Artisan::call("app:exchange-rates-update $currency --test");
            } else {
                Artisan::call("app:exchange-rates-update $currency");
            }
        }
    }
}
