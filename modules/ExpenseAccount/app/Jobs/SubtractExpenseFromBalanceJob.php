<?php

namespace Modules\ExpenseAccount\Jobs;

use App\Helpers\CurrencyConverter;
use App\Logs\UserBalanceLogger;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Modules\Auth\Models\User;
use Modules\Auth\Services\UserBalanceService;
use Modules\ExpenseAccount\Models\ExpenseAccount;

class SubtractExpenseFromBalanceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private User $user,
        private ExpenseAccount $expenseAccount,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        new UserBalanceService(
            user: $this->user,
            currencyConverter: CurrencyConverter::init(),
            userBalanceLogger: new UserBalanceLogger($this->user),
        )->subtractFromBalance($this->expenseAccount->amount);
    }

    public function middleware(): array
    {
        return [new WithoutOverlapping($this->user->id)];
    }

    public function failed($exception): void
    {
        report($exception);
    }
}
