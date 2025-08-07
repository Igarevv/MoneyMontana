<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\UseCases\Commands\ExpenseCategories;

use App\CommandBus\CommandHandler;
use Modules\ExpenseAccount\app\Exceptions\FailedToCreateExpenseCategoryError;
use Modules\ExpenseAccount\app\Exceptions\NotUniqueExpenseCategoryException;
use Modules\ExpenseAccount\app\Models\ExpenseCategory;
use Modules\ExpenseAccount\app\Repositories\ExpenseCategories\RReadExpenseCategory;
use Modules\ExpenseAccount\app\Repositories\ExpenseCategories\RWriteExpenseCategory;
use Throwable;

class ExpenseCategoryAddHandler extends CommandHandler
{
    public function __construct(
        private RWriteExpenseCategory $categoryWriteRepo,
        private RReadExpenseCategory $categoryReadRepo,
    ) {}

    public function handle(AddExpenseCategoryCommand $command): ExpenseCategory
    {
        $globalWithUsersCategory = $this->categoryReadRepo
            ->getPersonalWithGlobalsCategories($command->user, ['user_id', 'label'])
            ->transform(function (ExpenseCategory $expenseCategory) {
                return mb_strtolower($expenseCategory->labelByLocale());
            })
            ->collect();

        if ($globalWithUsersCategory->contains(mb_strtolower($command->categoryRo->category_name))) {
            throw new NotUniqueExpenseCategoryException();
        }

        try {
            return $this->categoryWriteRepo->createPersonalCategory($command->user, $command->categoryRo);
        } catch (Throwable $exception) {
            throw new FailedToCreateExpenseCategoryError($exception->getMessage());
        }
    }
}