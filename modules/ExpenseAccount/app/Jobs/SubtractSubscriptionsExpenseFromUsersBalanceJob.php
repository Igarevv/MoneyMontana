<?php

namespace Modules\ExpenseAccount\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Modules\ExpenseAccount\Enums\DurationType;
use Modules\ExpenseAccount\Enums\ExpenseType;
use Modules\ExpenseAccount\Models\ExpenseAccount;

class SubtractSubscriptionsExpenseFromUsersBalanceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        ExpenseAccount::query()->where('expense_type', ExpenseType::SUBSCRIPTION->value)->where(
            'payment_date',
            '<=',
            now()
        )
            ->with('user:id,balance,currency_code')
            ->chunk(100, function ($expenses) {
                DB::transaction(function () use ($expenses) {
                    $paymentDateToUpdate = [];

                    foreach ($expenses as $expense) {
                        SubtractExpenseFromBalanceJob::dispatchSync($expense->user, $expense);

                        $paymentDateToUpdate[] = [
                            'id' => $expense->id,
                            'payment_date' => DurationType::nextPaymentDateBy(
                                currentPaymentDate: $expense->payment_date,
                                durationType: $expense->duration_type,
                                durationValue: $expense->duration_value
                            ),
                        ];
                    }

                    $ids = collect($paymentDateToUpdate)->pluck('id')->all();

                    $sql = 'CASE id ';

                    foreach ($paymentDateToUpdate as $paymentDate) {
                        $dateParsed = Carbon::parse($paymentDate['payment_date']);
                        $sql .= "WHEN {$paymentDate['id']} THEN TIMESTAMP '{$dateParsed->toDateTimeString()}' ";
                    }

                    $sql .= 'END';

                    ExpenseAccount::query()
                        ->whereIn('id', $ids)
                        ->update(['payment_date' => DB::raw($sql)]);
                });
            });
    }

    public function failed($exception): void
    {
        report($exception);
    }
}
