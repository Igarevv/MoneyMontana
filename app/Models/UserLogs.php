<?php

namespace App\Models;

use App\Enums\UserLogsActionTypeEnum;
use MongoDB\Laravel\Eloquent\Model;

class UserLogs extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'user_logs';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'action_type',
        'description',
        'meta',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'meta' => 'array',
            'created_at' => 'datetime',
            'action_type' => UserLogsActionTypeEnum::class,
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (UserLogs $model) {
            $model->created_at = now();
        });
    }
}
