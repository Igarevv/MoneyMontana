<?php

return [
    'title' => 'Expense Accounting',
    'add_expense_form' => [
        'fields' => [
            'label' => 'Expense label',
            'description' => 'Expense description',
            'amount' => 'Amount',
            'currency' => 'Currency',
            'duration_type' => 'Duration type',
            'duration_value' => 'Duration value',
            'category' => 'Category',
        ],
    ],
    'exceptions' => [
        'failed_cr_category' => 'Error during category creation. Contact to support.',
        'not_all_categories_exists' => 'Some of selected categories do not exists.',
    ],
];