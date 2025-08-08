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
    'logs' => [
        'expenses' => [
            'add_one_time' => 'One-time expense added - :expense_name',
        ],
        'balance' => [
            'subtract' => 'Deducted from balance - :amount (:currency). Current balance - :new_balance (:currency). :conversion',
            'converted' => 'Converted :from_amount (:from_currency) → :to_amount (:to_currency).',
        ],
    ],
];