<?php

namespace Modules\ExpenseAccount\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateExpenseCategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'category_name' => ['required', 'string'],
            'color' => ['required', 'hex_color'],
        ];
    }
}
