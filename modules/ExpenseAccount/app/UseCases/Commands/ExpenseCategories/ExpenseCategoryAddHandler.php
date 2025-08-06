<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\UseCases\Commands\ExpenseCategories;

use App\CommandBus\CommandHandler;
use Modules\ExpenseAccount\app\Exceptions\FailedToCreateExpenseCategoryError;
use Modules\ExpenseAccount\app\Exceptions\NotUniqueExpenseCategoryException;
use Modules\ExpenseAccount\Repositories\ExpenseCategories\RReadExpenseCategory;
use Modules\ExpenseAccount\Repositories\ExpenseCategories\RWriteExpenseCategory;
use Throwable;

class ExpenseCategoryAddHandler extends CommandHandler
{
    public function __construct(
        private RWriteExpenseCategory $categoryWriteRepo,
        private RReadExpenseCategory $categoryReadRepo,
    ) {}

    public function handle(AddExpenseCategoryCommand $command): void
    {
        $globalWithUsersCategory = $this->categoryReadRepo
            ->getPersonalWithGlobalsCategories($command->user, ['user_id', 'label'])
            ->map(function (array $data) {
                return mb_strtolower($data['label']);
            });

        if ($globalWithUsersCategory->contains(mb_strtolower($command->categoryRo->category_name))) {
            throw new NotUniqueExpenseCategoryException();
        }

        try {
            $this->categoryWriteRepo->createPersonalCategory($command->user, $command->categoryRo);
        } catch (Throwable $exception) {
            throw new FailedToCreateExpenseCategoryError($exception->getMessage());
        }
    }
}