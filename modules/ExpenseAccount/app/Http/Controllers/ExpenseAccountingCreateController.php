<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\ExpenseAccount\app\Http\Requests\ExpenseAccountAddRequest;

class ExpenseAccountingCreateController extends Controller
{
    public function addNewExpense(ExpenseAccountAddRequest $request) {}
}