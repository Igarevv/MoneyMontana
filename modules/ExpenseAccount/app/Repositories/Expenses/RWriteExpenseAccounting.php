<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\app\Repositories\Expenses;

use Modules\Auth\Models\User;
use Modules\ExpenseAccount\Http\RequestObjects\AddExpenseAccountRO;
use Modules\ExpenseAccount\Models\ExpenseAccount;

class RWriteExpenseAccounting
{
    public function saveExpense(User $user, AddExpenseAccountRO $expenseAccountRO): ExpenseAccount
    {
        $expense = $user->expenseAccounts()->create([
            'label' => $expenseAccountRO->label,
            'description' => $expenseAccountRO->description,
            'amount' => $expenseAccountRO->amount,
            'currency' => $expenseAccountRO->currency,
            'duration_value' => $expenseAccountRO->duration_value,
            'duration_type' => $expenseAccountRO->duration_type,
            'created_at' => $expenseAccountRO->created_at,
        ]);


        $expense->expenseCategories()->attach($expenseAccountRO->categories);

        return $expense;
    }
}