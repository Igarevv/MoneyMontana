<?php

return [
    'title' => 'Учет расходов',
    'add_expense_form' => [
        'fields' => [
            'label' => 'Название расхода',
            'description' => 'Описание расхода',
            'amount' => 'Сумма',
            'currency' => 'Валюта',
            'duration_type' => 'Тип длительности',
            'duration_value' => 'Длительность',
            'category' => 'Категория',
        ],
    ],
    'exceptions' => [
        'failed_cr_category' => 'Ошибки при создании категории. Свяжитесь с поддержкой.',
        'not_all_categories_exists' => 'Некоторые выбранные категории не существуют.',
    ],
    'logs' => [
        'expenses' => [
            'add_one_time' => 'Добавлен расход - :expense_name',
        ],
        'balance' => [
            'subtract' => 'С баланса снято - :amount (:currency). Текущий баланс - :new_balance (:currency). :conversion',
            'converted' => 'Конвертировано :from_amount (:from_currency) → :to_amount (:to_currency).',
        ],
    ],
];