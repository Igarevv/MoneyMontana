<?php

namespace Modules\ExpenseAccount\Services;

use Illuminate\Database\Eloquent\Collection;
use Modules\Auth\Models\User;
use Modules\ExpenseAccount\app\Exceptions\FailedToCreateExpenseCategoryError;
use Modules\ExpenseAccount\app\Exceptions\NotUniqueExpenseCategoryException;
use Modules\ExpenseAccount\app\Http\RequestObjects\CreateExpenseCategoryRo;
use Modules\ExpenseAccount\app\Models\ExpenseCategory;
use Throwable;

class ExpenseCategoriesService
{
    public function getGlobalWithUsersCategories(User $user): Collection
    {
        return ExpenseCategory::query()
            ->whereNull('user_id')
            ->orWhere('user_id', $user->id)
            ->get([
                'id',
                'label',
                'color',
                'user_id',
            ])
            ->transform(function (ExpenseCategory $category) use ($user) {
                return [
                    'id' => $category->id,
                    'label' => $category->labelByLocale(),
                    'color' => $category->color,
                    'is_global' => is_null($category->user_id),
                ];
            });
    }

    public function createUserPersonalExpenseCategory(User $user, CreateExpenseCategoryRo $data): ExpenseCategory
    {
        $globalWithUsersCategory = $this
            ->getGlobalWithUsersCategories($user)
            ->map(function (array $data) {
                return mb_strtolower($data['label']);
            });

        if ($globalWithUsersCategory->contains(mb_strtolower($data->category_name))) {
            throw new NotUniqueExpenseCategoryException();
        }

        try {
            return ExpenseCategory::query()->create([
                'label' => $data->category_name,
                'color' => $data->color,
                'user_id' => $user->id,
            ]);
        } catch (Throwable $exception) {
            throw new FailedToCreateExpenseCategoryError($exception);
        }
    }
}
