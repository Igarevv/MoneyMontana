<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\ExpenseAccount\Services\ExpenseCategoriesService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExpenseCategoriesController extends Controller
{
    public function __construct(private ExpenseCategoriesService $expenseCategoriesService) {}

    public function addCategory() {}

    public function getGlobalWithUsersCategories(Request $request)
    {
        $categories = $this->expenseCategoriesService->getGlobalWithUsersCategories($request->user());

        if ($categories->isEmpty()) {
            throw new NotFoundHttpException();
        }

        return response()->json([
            'data' => [
                'attributes' => $categories,
            ],
        ]);
    }
}