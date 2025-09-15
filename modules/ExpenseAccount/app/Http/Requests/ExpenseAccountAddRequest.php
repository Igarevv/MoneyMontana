<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\ExpenseAccount\Enums\DurationType;
use Modules\ExpenseAccount\Enums\ExpenseType;
use Modules\ExpenseAccount\Http\Rules\ExpenseCategoriesExistsRule;

class ExpenseAccountAddRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => ['required', Rule::in(ExpenseType::stringCases())],
            'label' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'currency' => ['required', 'string', 'size:3'],
            'created_at' => ['nullable', 'required_if:type,'.ExpenseType::DISPOSABLE_S, 'date'],
            'duration_type' => [
                'nullable',
                'required_if:type,'.ExpenseType::REPEATABLE_S.','.ExpenseType::SUBSCRIPTION_S,
                Rule::in(DurationType::stringCases()),
            ],
            'duration_value' => ['nullable', 'required_with:duration_type', 'integer', 'min:1'],
            'payment_date' => [
                'nullable',
                'required_if:type,'.ExpenseType::REPEATABLE_S.','.ExpenseType::SUBSCRIPTION_S,
                'date'
            ],
            'categories' => ['nullable', 'array', new ExpenseCategoriesExistsRule()],
        ];
    }

    public function attributes(): array
    {
        return [
            'label' => __('expenseaccount::base.add_expense_form.fields.label'),
            'description' => __('expenseaccount::base.add_expense_form.fields.description'),
            'amount' => __('expenseaccount::base.add_expense_form.fields.amount'),
            'categories' => __('expenseaccount::base.add_expense_form.fields.category'),
            'currency' => __('expenseaccount::base.add_expense_form.fields.currency'),
            'duration_type' => __('expenseaccount::base.add_expense_form.fields.duration_type'),
            'duration_value' => __('expenseaccount::base.add_expense_form.fields.duration_value'),
        ];
    }
}
