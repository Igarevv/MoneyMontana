<?php

namespace Modules\ExpenseAccount\Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase;
use Modules\Auth\Models\User;
use Modules\ExpenseAccount\Jobs\SubtractSubscriptionsExpenseFromUsersBalanceJob;
use Modules\ExpenseAccount\Models\ExpenseAccount;

class SubtractSubscriptionExpenseTest extends TestCase
{
    use DatabaseTransactions;

    public function test_can_subtract_user_balance_on_subscription_expense(): void
    {
        $user = User::factory()
            ->state(['balance' => 1000000, 'currency_code' => 'USD'])
            ->create();

        $expense1 = ExpenseAccount::factory()
            ->subscription()
            ->state(['payment_date' => now()->subDay()])
            ->user($user)
            ->create();

        $expense2 = ExpenseAccount::factory()
            ->subscription()
            ->state(['payment_date' => now()->subDay()])
            ->user($user)
            ->create();

        $job = new SubtractSubscriptionsExpenseFromUsersBalanceJob();

        $job->handle();

        $updated1 = $expense1->fresh();

        $updated2 = $expense2->fresh();

        $this->assertNotEquals($expense1->payment_date->toString(), $updated1->payment_date->toString());

        $this->assertNotEquals($expense2->payment_date->toString(), $updated2->payment_date->toString());

        $userRefreshed = $user->fresh();

        $this->assertNotEquals($user->balance, $userRefreshed->balance);
    }
}
