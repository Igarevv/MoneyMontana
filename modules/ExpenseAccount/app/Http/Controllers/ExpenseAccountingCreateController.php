<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\ExpenseAccount\Http\RequestObjects\AddExpenseAccountRO;
use Modules\ExpenseAccount\Http\Requests\ExpenseAccountAddRequest;

class ExpenseAccountingCreateController extends Controller
{
    public function addNewExpense(ExpenseAccountAddRequest $request)
    {
        $expenseData = AddExpenseAccountRO::fromRequest($request);

        dd($expenseData);
    }
}