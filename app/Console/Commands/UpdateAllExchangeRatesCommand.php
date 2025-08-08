<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class UpdateAllExchangeRatesCommand extends Command
{
    protected $signature = 'app:update-all-exchange-rates-command';

    protected $description = 'Initial update for all exchange rates.';

    public function handle(): void
    {
        $allCurrencies = config('currency.allowed');

        foreach ($allCurrencies as $currency) {
            $this->info('Updating currency '.$currency);

            Artisan::call("app:exchange-rates-update $currency");
        }
    }
}
