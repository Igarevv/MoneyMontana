<?php

declare(strict_types=1);

namespace Modules\ExpenseAccount\database\seeders;

use Illuminate\Database\Seeder;
use Modules\ExpenseAccount\Models\ExpenseCategory;

class ExpenseCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        ExpenseCategory::query()->insert([
            [
                'label' => json_encode(['ru' => 'Еда', 'en' => 'Food']),
                'color' => '#cbd5e1',
                'user_id' => null,
            ],
            [
                'label' => json_encode(['ru' => 'Коммунальные услуги', 'en' => 'Utilities']),
                'color' => '#d6d3d1',
                'user_id' => null,
            ],
            [
                'label' => json_encode(['ru' => 'Транспорт', 'en' => 'Transport']),
                'color' => '#fca5a5',
                'user_id' => null,
            ],
            [
                'label' => json_encode(['ru' => 'Здоровье', 'en' => 'Health']),
                'color' => '#bef264',
                'user_id' => null,
            ],
            [
                'label' => json_encode(['ru' => 'Спорт', 'en' => 'Sport']),
                'color' => '#6ee7b7',
                'user_id' => null,
            ],
            [
                'label' => json_encode(['ru' => 'Образование', 'en' => 'Education']),
                'color' => '#a5b4fc',
                'user_id' => null,
            ],
            [
                'label' => json_encode(['ru' => 'Покупки', 'en' => 'Shopping']),
                'color' => '#67e8f9',
                'user_id' => null,
            ],
            [
                'label' => json_encode(['ru' => 'Путешествия', 'en' => 'Travel']),
                'color' => '#f9a8d4',
                'user_id' => null,
            ],
            [
                'label' => json_encode(['ru' => 'Подарки', 'en' => 'Gifts']),
                'color' => '#a5b4fc',
                'user_id' => null,
            ],
        ]);
    }
}