<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\app\Http\Controllers;

use App\CommandBus\CommandBus;
use App\CommandBus\QueryBus;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\ExpenseAccount\app\Http\RequestObjects\CreateExpenseCategoryRo;
use Modules\ExpenseAccount\Http\Requests\CreateExpenseCategoryRequest;
use Modules\ExpenseAccount\UseCases\Commands\ExpenseCategories\AddExpenseCategoryCommand;
use Modules\ExpenseAccount\UseCases\Queries\ExpenseCategories\GetExpenseCategoriesQuery;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExpenseCategoriesController extends Controller
{
    public function __construct(
        private CommandBus $commandBus,
        private QueryBus $queryBus,
    ) {}

    public function addCategory(CreateExpenseCategoryRequest $request): JsonResponse
    {
        $createExpenseCategoryRo = CreateExpenseCategoryRo::fromRequest($request);

        $this->commandBus->dispatch(
            new AddExpenseCategoryCommand(
                $createExpenseCategoryRo,
                $request->user(),
            ),
        );

        return response()->json([
            'data' => [
                'attributes' => $createExpenseCategoryRo->originalData,
            ],
        ]);
    }

    public function getGlobalWithUsersCategories(Request $request): JsonResponse
    {
        $categories = $this->queryBus->ask(
            new GetExpenseCategoriesQuery(
                GetExpenseCategoriesQuery::GET_G_P_CATEGORIES,
                $request->user(),
            ),
        );

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