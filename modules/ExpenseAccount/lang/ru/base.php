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
];