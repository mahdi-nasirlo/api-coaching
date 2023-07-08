<?php

namespace Modules\Meeting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coach extends Model
{
    use HasFactory;

    protected $guarded = ['created_at', 'updated_at'];

    protected static function newFactory()
    {
        return \Modules\Meeting\Database\factories\CoachFactory::new();
    }
}
