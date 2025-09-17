<?php

namespace Modules\ExpenseAccount\Tests\Feature;

use App\CommandBus\CommandHandler;
use App\Helpers\CurrencyConverter;
use App\Logs\UserBalanceLogger;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Validator;
use Modules\Auth\Models\User;
use Modules\Auth\Services\UserBalanceService;
use Modules\ExpenseAccount\app\Logs\Expenses\AddUserExpenseLogs;
use Modules\ExpenseAccount\app\Repositories\Expenses\RWriteExpenseAccounting;
use Modules\ExpenseAccount\Enums\DurationType;
use Modules\ExpenseAccount\Enums\ExpenseType;
use Modules\ExpenseAccount\Http\RequestObjects\AddExpenseAccountRO;
use Modules\ExpenseAccount\Http\Requests\ExpenseAccountAddRequest;
use Modules\ExpenseAccount\Jobs\SubtractExpenseFromBalanceJob;
use Modules\ExpenseAccount\UseCases\Commands\Expenses\OneTimeExpense\AddOneTimeExpense\AddOneTimeExpenseCommand;
use Modules\ExpenseAccount\UseCases\Commands\Expenses\OneTimeExpense\AddOneTimeExpense\AddOneTimeExpenseHandler;
use Modules\ExpenseAccount\UseCases\Commands\Expenses\RepeatableExpense\AddRepeatableExpense\AddRepeatableExpenseCommand;
use Modules\ExpenseAccount\UseCases\Commands\Expenses\RepeatableExpense\AddRepeatableExpense\AddRepeatableExpenseHandler;
use Modules\ExpenseAccount\UseCases\Commands\Expenses\SubscriptionExpense\AddSubscriptionExpense\AddSubscriptionExpenseCommand;
use Modules\ExpenseAccount\UseCases\Commands\Expenses\SubscriptionExpense\AddSubscriptionExpense\AddSubscriptionExpenseHandler;

class AddExpenseAccountingTest extends TestCase
{
    use DatabaseTransactions;

    public function test_can_add_one_time_expense(): void
    {
        Bus::fake();

        $user = User::factory()->create();

        $request = $this->makeFormRequest(ExpenseAccountAddRequest::class, [
            'type' => ExpenseType::DISPOSABLE_S,
            'label' => 'Future expense',
            'description' => 'Some description',
            'amount' => '100.50',
            'currency' => 'USD',
            'created_at' => now()->addHour()->toISOString(),
            'payment_date' => null,
        ]);

        $ro = AddExpenseAccountRO::fromRequest($request);

        $handler = $this->getExpenseHandler(ExpenseType::DISPOSABLE, $user);

        $handler->handle(new AddOneTimeExpenseCommand($user, $ro));

        $this->assertDatabaseHas('expense_accounts', [
            'user_id' => $user->id,
            'expense_type' => ExpenseType::DISPOSABLE->value,
            'label' => 'Future expense',
            'description' => 'Some description',
            'amount' => 10050,
            'currency' => 'USD',
        ]);

        Bus::assertDispatched(SubtractExpenseFromBalanceJob::class);
    }

    public function test_will_subtract_from_balance_if_expense_has_already_occurred(): void
    {
        $user = User::factory()->state([
            'balance' => '20000',
            'currency_code' => 'USD',
        ])->create();

        $request = $this->makeFormRequest(ExpenseAccountAddRequest::class, [
            'type' => ExpenseType::DISPOSABLE_S,
            'label' => 'Future expense',
            'description' => 'Some description',
            'amount' => '100.50',
            'currency' => 'USD',
            'created_at' => now()->subDay(),
            'payment_date' => null,
        ]);

        $ro = AddExpenseAccountRO::fromRequest($request);

        $handler = $this->getExpenseHandler(ExpenseType::DISPOSABLE, $user);

        $handler->handle(new AddOneTimeExpenseCommand($user, $ro));

        $this->assertTrue($user->refresh()->balance->isEqualTo('99.50'));
    }

    public function test_can_add_subscription_expense(): void
    {
        $user = User::factory()->create();

        $request = $this->makeFormRequest(ExpenseAccountAddRequest::class, [
            'type' => ExpenseType::SUBSCRIPTION_S,
            'label' => 'Future expense',
            'description' => 'Some description',
            'amount' => '100.50',
            'currency' => 'USD',
            'duration_type' => DurationType::MONTHS_S,
            'duration_value' => 1,
            'created_at' => now()->addHour()->toISOString(),
            'payment_date' => Carbon::now()->addDay()->toISOString(),
        ]);

        $ro = AddExpenseAccountRO::fromRequest($request);

        $handler = $this->getExpenseHandler(ExpenseType::SUBSCRIPTION, $user);

        $handler->handle(new AddSubscriptionExpenseCommand($user, $ro));

        $this->assertDatabaseHas('expense_accounts', [
            'user_id' => $user->id,
            'expense_type' => ExpenseType::SUBSCRIPTION->value,
            'label' => 'Future expense',
            'description' => 'Some description',
            'amount' => 10050,
            'currency' => 'USD',
        ]);
    }

    public function test_will_subtract_from_balance_if_already_subscription_paid_in_current_period(): void
    {
        $user = User::factory()
            ->state([
                'balance' => '20000',
                'currency_code' => 'USD',
            ])
            ->create();

        $request = $this->makeFormRequest(ExpenseAccountAddRequest::class, [
            'type' => ExpenseType::SUBSCRIPTION_S,
            'label' => 'Future expense',
            'description' => 'Some description',
            'amount' => '100.50',
            'currency' => 'USD',
            'duration_type' => DurationType::DAYS_S,
            'duration_value' => 15,
            'created_at' => null,
            // null in this request means that user has already paid for subscription in current period for ex. this month
            'payment_date' => Carbon::now()->addDay()->toISOString(),
        ]);

        $ro = AddExpenseAccountRO::fromRequest($request);

        $handler = $this->getExpenseHandler(ExpenseType::SUBSCRIPTION, $user);

        $handler->handle(new AddSubscriptionExpenseCommand($user, $ro));

        $this->assertTrue(
            $user->refresh()->balance->isEqualTo('99.50')
        );
    }

    public function test_can_add_repeatable_expense(): void
    {
        $user = User::factory()->create();

        $request = $this->makeFormRequest(ExpenseAccountAddRequest::class, [
            'type' => ExpenseType::REPEATABLE_S,
            'label' => 'Future expense',
            'description' => 'Some description',
            'amount' => '100.50',
            'currency' => 'USD',
            'duration_type' => DurationType::MONTHS_S,
            'duration_value' => 1,
            'created_at' => now()->addHour()->toISOString(),
            'payment_date' => Carbon::now()->addDay()->toISOString(),
        ]);

        $ro = AddExpenseAccountRO::fromRequest($request);

        $handler = $this->getExpenseHandler(ExpenseType::REPEATABLE, $user);

        $handler->handle(new AddRepeatableExpenseCommand($user, $ro));

        $this->assertDatabaseHas('expense_accounts', [
            'user_id' => $user->id,
            'expense_type' => ExpenseType::REPEATABLE->value,
            'label' => 'Future expense',
            'description' => 'Some description',
            'amount' => 10050,
            'currency' => 'USD',
        ]);
    }

    public function test_will_subtract_from_balance_if_user_has_already_paid_for_repeatable_in_current_period(): void
    {
        $user = User::factory()
            ->state([
                'balance' => '20000',
                'currency_code' => 'USD',
            ])
            ->create();

        $request = $this->makeFormRequest(ExpenseAccountAddRequest::class, [
            'type' => ExpenseType::REPEATABLE_S,
            'label' => 'Future expense',
            'description' => 'Some description',
            'amount' => '100.50',
            'currency' => 'USD',
            'duration_type' => DurationType::MONTHS_S,
            'duration_value' => 1,
            'created_at' => null,
            // null in this request means that user has already paid for subscription in current period for ex. this month
            'payment_date' => Carbon::now()->addDay()->toISOString(),
        ]);

        $ro = AddExpenseAccountRO::fromRequest($request);

        $handler = $this->getExpenseHandler(ExpenseType::REPEATABLE, $user);

        $handler->handle(new AddRepeatableExpenseCommand($user, $ro));

        $this->assertTrue(
            $user->refresh()->balance->isEqualTo('99.50')
        );
    }

    private function getExpenseHandler(ExpenseType $type, User $user): CommandHandler
    {
        $class = match ($type) {
            ExpenseType::DISPOSABLE => AddOneTimeExpenseHandler::class,
            ExpenseType::SUBSCRIPTION => AddSubscriptionExpenseHandler::class,
            ExpenseType::REPEATABLE => AddRepeatableExpenseHandler::class
        };

        return new $class(
            new UserBalanceService($user, CurrencyConverter::init(), new UserBalanceLogger($user)),
            new RWriteExpenseAccounting(),
            new AddUserExpenseLogs($user)
        );
    }

    private function makeFormRequest(string $class, array $data): FormRequest
    {
        /** @var \Illuminate\Foundation\Http\FormRequest $request */
        $request = new $class();

        $request->merge($data);

        $validator = Validator::make($request->all(), $request->rules());

        $request->setContainer(app())->setRedirector(app('redirect'));

        $request->setValidator($validator);

        return $request;
    }
}
