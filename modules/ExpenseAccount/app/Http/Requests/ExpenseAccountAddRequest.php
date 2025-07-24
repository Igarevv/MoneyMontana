<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\ExpenseAccount\app\Enums\DurationType;
use Modules\ExpenseAccount\app\Enums\ExpenseType;

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
            'duration_type' => [
                'required_if:type,'.ExpenseType::REPEATABLE_S.','.ExpenseType::SUBSCRIPTION_S,
                Rule::in(DurationType::stringCases()),
            ],
            'duration_value' => ['required_with:duration_type', 'integer', 'min:1'],
            'category' => ['nullable', Rule::exists('expense_categories', 'id')],
        ];
    }
}