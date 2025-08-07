<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\Http\Controllers;

use App\CommandBus\CommandBus;
use App\Http\Controllers\Controller;
use Modules\ExpenseAccount\Http\RequestObjects\AddExpenseAccountRO;
use Modules\ExpenseAccount\Http\Requests\ExpenseAccountAddRequest;

class ExpenseAccountingCreateController extends Controller
{
    public function __construct(
        private CommandBus $commandBus,
    ) {}

    public function addNewExpense(ExpenseAccountAddRequest $request)
    {
        $expenseData = AddExpenseAccountRO::fromRequest($request);

        $this->commandBus->dispatch(
            new ($expenseData->type->commandInstance())($request->user(), $expenseData),
        );
    }
}