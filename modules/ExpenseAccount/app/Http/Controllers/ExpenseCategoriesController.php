<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\ExpenseAccount\app\Http\RequestObjects\CreateExpenseCategoryRo;
use Modules\ExpenseAccount\Http\Requests\CreateExpenseCategoryRequest;
use Modules\ExpenseAccount\Services\ExpenseCategoriesService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExpenseCategoriesController extends Controller
{
    public function __construct(private ExpenseCategoriesService $expenseCategoriesService) {}

    public function addCategory(CreateExpenseCategoryRequest $request): JsonResponse
    {
        $createExpenseCategoryRo = CreateExpenseCategoryRo::fromRequest($request);

        $expenseCategory = $this->expenseCategoriesService->createUserPersonalExpenseCategory(
            user: $request->user(),
            data: $createExpenseCategoryRo,
        );

        return response()->json([
            'data' => [
                'attributes' => $expenseCategory->toArray(),
            ],
        ]);
    }

    public function getGlobalWithUsersCategories(Request $request): JsonResponse
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