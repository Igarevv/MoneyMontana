<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class ExpenseAccountingRetrieveController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('ExpenseAccount', [
            'title' => __('expenseaccount::base.title'),
        ]);
    }
}