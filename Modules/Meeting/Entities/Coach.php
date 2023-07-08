<?php

namespace Modules\Meeting\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Meeting\Database\factories\CoachFactory;
use Modules\Meeting\Enums\CoachStatusEnum;

class Coach extends Model
{
    use HasFactory;

    protected $guarded = ['created_at', 'updated_at'];

    protected $casts = ['status' => CoachStatusEnum::class];

    protected static function newFactory(): CoachFactory
    {
        return CoachFactory::new();
    }
}
